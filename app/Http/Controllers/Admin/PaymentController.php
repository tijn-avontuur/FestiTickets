<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PaymentController extends Controller
{
    /**
     * Display a listing of all payments
     */
    public function index(): View
    {
        $payments = Payment::with(['order.user', 'order.event'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show detailed payment information
     */
    public function show(Payment $payment): View
    {
        $payment->load(['order.user', 'order.event']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Preview the ticket PDF for a payment
     */
    public function previewTicket(Payment $payment): Response
    {
        $order = $payment->order;
        $order->load(['user', 'event']);

        // Generate QR code
        $qrCode = new QrCode($order->order_number);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodeHtml = '<img src="' . $result->getDataUri() . '" style="width: 250px; height: 250px;" />';

        // Generate PDF
        $pdf = Pdf::loadView('pdf.ticket', [
            'order' => $order,
            'qrCode' => $qrCodeHtml
        ]);

        return $pdf->stream('ticket-' . $order->order_number . '.pdf');
    }
}
