<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}
