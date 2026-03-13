<?php

namespace App\Exports\Sheets;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class EventSalesSummarySheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithTitle
{
    public function collection(): Collection
    {
        return Event::query()
            ->leftJoin('orders', 'events.id', '=', 'orders.event_id')
            ->leftJoin('payments', function ($join) {
                $join->on('orders.id', '=', 'payments.order_id')
                    ->where('payments.status', '=', 'paid');
            })
            ->select(
                'events.id',
                'events.name',
                'events.location',
                'events.date',
                'events.total_tickets',
                'events.price',
                DB::raw('COALESCE(SUM(CASE WHEN payments.id IS NOT NULL THEN orders.quantity ELSE 0 END), 0) as tickets_verkocht'),
                DB::raw('COALESCE(SUM(CASE WHEN payments.id IS NOT NULL THEN orders.quantity * orders.ticket_price ELSE 0 END), 0) as ticket_omzet'),
                DB::raw('COALESCE(SUM(CASE WHEN payments.id IS NOT NULL THEN orders.service_fee ELSE 0 END), 0) as service_fee_omzet'),
                DB::raw('COALESCE(SUM(CASE WHEN payments.id IS NOT NULL THEN orders.total_amount ELSE 0 END), 0) as totaal_omzet'),
                DB::raw('COALESCE(COUNT(CASE WHEN payments.id IS NOT NULL THEN orders.id END), 0) as betaalde_orders')
            )
            ->groupBy('events.id', 'events.name', 'events.location', 'events.date', 'events.total_tickets', 'events.price')
            ->orderBy('events.date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Evenement',
            'Locatie',
            'Datum',
            'Ticketprijs',
            'Beschikbare tickets',
            'Verkochte tickets',
            'Resterende tickets',
            'Bezetting (%)',
            'Betaalde orders',
            'Ticket omzet (€)',
            'Service fee omzet (€)',
            'Totale omzet (€)',
        ];
    }

    public function map($event): array
    {
        $ticketsVerkocht = (int) $event->tickets_verkocht;
        $beschikbareTickets = (int) $event->total_tickets;
        $resterendeTickets = max($beschikbareTickets - $ticketsVerkocht, 0);
        $bezetting = $beschikbareTickets > 0
            ? round(($ticketsVerkocht / $beschikbareTickets) * 100, 2)
            : 0;

        $eventDate = $event->date
            ? Carbon::parse($event->date)->format('d-m-Y H:i')
            : '-';

        return [
            $event->name,
            $event->location,
            $eventDate,
            (float) $event->price,
            $beschikbareTickets,
            $ticketsVerkocht,
            $resterendeTickets,
            $bezetting,
            (int) $event->betaalde_orders,
            round((float) $event->ticket_omzet, 2),
            round((float) $event->service_fee_omzet, 2),
            round((float) $event->totaal_omzet, 2),
        ];
    }

    public function title(): string
    {
        return 'Eventverkoop';
    }
}
