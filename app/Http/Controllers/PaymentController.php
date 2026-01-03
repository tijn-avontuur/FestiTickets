<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
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
}
