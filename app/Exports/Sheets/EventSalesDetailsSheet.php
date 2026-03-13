<?php

namespace App\Exports\Sheets;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class EventSalesDetailsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithTitle
{
    public function collection(): Collection
    {
        return Order::query()
            ->with(['event', 'user', 'payment'])
            ->whereHas('payment', function ($query) {
                $query->where('status', 'paid');
            })
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ordernummer',
            'Evenement',
            'Klant',
            'E-mail',
            'Aantal tickets',
            'Ticketprijs (€)',
            'Service fee (€)',
            'Totaalbedrag (€)',
            'Betaalmethode',
            'Betaalstatus',
            'Betaald op',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->event?->name,
            $order->user?->name,
            $order->user?->email,
            (int) $order->quantity,
            round((float) $order->ticket_price, 2),
            round((float) $order->service_fee, 2),
            round((float) $order->total_amount, 2),
            $order->payment?->method ? ucfirst($order->payment->method) : '-',
            ucfirst($order->payment?->status ?? '-'),
            $order->payment?->paid_at?->format('d-m-Y H:i') ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Orderdetails';
    }
}
