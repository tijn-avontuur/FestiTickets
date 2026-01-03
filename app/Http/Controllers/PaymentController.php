<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Payment;
use App\Mail\OrderConfirmation;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mollie\Laravel\Facades\Mollie;

class PaymentController extends Controller
{
    /**
     * Create a new payment for the event
     */
    public function create(Request $request, Event $event)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $validated['quantity'];

        // Check if enough tickets available
        if ($quantity > $event->total_tickets) {
            return redirect()->route('events.checkout', $event)
                ->with('error', 'Er zijn niet genoeg tickets beschikbaar.');
        }

        // Calculate costs
        $ticketPrice = $event->price;
        $subtotal = $ticketPrice * $quantity;
        $serviceFeePercentage = 2.5;
        $serviceFee = $subtotal * ($serviceFeePercentage / 100);
        $total = $subtotal + $serviceFee;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'quantity' => $quantity,
            'ticket_price' => $ticketPrice,
            'service_fee' => $serviceFee,
            'total_amount' => $total,
            'status' => 'pending',
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
        ]);

        // Create Mollie payment
        $paymentData = [
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($total, 2, '.', ''),
            ],
            'description' => "Tickets voor {$event->name}",
            'redirectUrl' => route('payment.return', $order),
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ],
        ];

        // Only add webhook for production/public environments
        if (!app()->environment('local')) {
            $paymentData['webhookUrl'] = route('payment.webhook');
        }

        $payment = Mollie::api()->payments->create($paymentData);

        // Store payment in database
        Payment::create([
            'order_id' => $order->id,
            'mollie_payment_id' => $payment->id,
            'status' => $payment->status,
            'amount' => $total,
            'currency' => 'EUR',
        ]);

        // Redirect to Mollie checkout
        return redirect($payment->getCheckoutUrl());
    }

    /**
     * Handle payment return from Mollie
     */
    public function return(Order $order)
    {
        $payment = $order->payment;

        if (!$payment) {
            return redirect()->route('events.index')
                ->with('error', 'Betaling niet gevonden.');
        }

        // Get latest payment status from Mollie
        $molliePayment = Mollie::api()->payments->get($payment->mollie_payment_id);

        // Update payment status
        $payment->update([
            'status' => $molliePayment->status,
            'method' => $molliePayment->method,
            'paid_at' => $molliePayment->isPaid() ? now() : null,
        ]);

        if ($molliePayment->isPaid()) {
            // Update order status
            $order->update(['status' => 'paid']);

            // Decrease available tickets
            $order->event->decrement('total_tickets', $order->quantity);

            // Generate and save PDF ticket
            $this->generateTicketPdf($order);

            // Refresh order to get updated ticket_path and reload relationships
            $order->refresh()->load(['user', 'event']);

            // Send order confirmation email with PDF attachment
            Mail::to($order->user->email)->send(new OrderConfirmation($order));

            return redirect()->route('payment.success', $order);
        }

        if ($molliePayment->isFailed() || $molliePayment->isExpired() || $molliePayment->isCanceled()) {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('payment.failed', $order);
        }

        // Payment still pending
        return redirect()->route('payment.pending', $order);
    }

    /**
     * Handle Mollie webhook
     */
    public function webhook(Request $request)
    {
        $paymentId = $request->input('id');

        if (!$paymentId) {
            return response()->json(['error' => 'No payment ID provided'], 400);
        }

        // Find payment in database
        $payment = Payment::where('mollie_payment_id', $paymentId)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Get latest status from Mollie
        $molliePayment = Mollie::api()->payments->get($paymentId);

        // Update payment
        $payment->update([
            'status' => $molliePayment->status,
            'method' => $molliePayment->method,
            'paid_at' => $molliePayment->isPaid() ? now() : null,
        ]);

        $order = $payment->order;

        if ($molliePayment->isPaid() && $order->status !== 'paid') {
            // Update order
            $order->update(['status' => 'paid']);

            // Decrease available tickets
            $order->event->decrement('total_tickets', $order->quantity);

            // Here you could send confirmation email
        }

        if ($molliePayment->isFailed() || $molliePayment->isExpired() || $molliePayment->isCanceled()) {
            $order->update(['status' => 'cancelled']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show success page
     */
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.success', compact('order'));
    }

    /**
     * Show failed page
     */
    public function failed(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.failed', compact('order'));
    }

    /**
     * Show pending page
     */
    public function pending(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.pending', compact('order'));
    }

    /**
     * Download ticket PDF
     */
    public function downloadTicket(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if ticket exists
        if (!$order->ticket_path || !Storage::exists($order->ticket_path)) {
            // Generate PDF if it doesn't exist
            $this->generateTicketPdf($order);
        }

        return Storage::download($order->ticket_path, 'ticket-' . $order->order_number . '.pdf');
    }

    /**
     * Preview ticket PDF in browser (for testing)
     */
    public function previewTicket(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Load order with relationships
        $order->load(['user', 'event']);

        // Generate QR Code - simpelste aanpak
        $qrCode = new QrCode($order->order_number);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodeHtml = '<img src="' . $result->getDataUri() . '" alt="QR Code" style="width: 250px; height: 250px;" />';

        // Generate and stream PDF directly to browser
        $pdf = Pdf::loadView('pdf.ticket', [
            'order' => $order,
            'qrCode' => $qrCodeHtml,
        ]);

        return $pdf->stream('ticket-' . $order->order_number . '.pdf');
    }

    /**
     * Generate and save PDF ticket
     */
    private function generateTicketPdf(Order $order)
    {
        // Load order with relationships
        $order->load(['user', 'event']);

        // Generate QR Code - simpelste aanpak
        $qrCode = new QrCode($order->order_number);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodeHtml = '<img src="' . $result->getDataUri() . '" alt="QR Code" style="width: 250px; height: 250px;" />';

        // Generate PDF from view
        $pdf = Pdf::loadView('pdf.ticket', [
            'order' => $order,
            'qrCode' => $qrCodeHtml,
        ]);

        // Create tickets directory if it doesn't exist
        if (!Storage::exists('tickets')) {
            Storage::makeDirectory('tickets');
        }

        // Save PDF to storage
        $filename = 'ticket-' . $order->order_number . '.pdf';
        $path = 'tickets/' . $filename;

        Storage::put($path, $pdf->output());

        // Update order with ticket path
        $order->update(['ticket_path' => $path]);

        return $path;
    }
}

