<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket - {{ $order->event->name }}</title>
    <style>
        /* DOMPDF ondersteunt geen Flexbox/Grid, dus we gebruiken table-based layout */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            padding: 10px;
        }

        /* Header met branding */
        .header {
            text-align: center;
            border-bottom: 4px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #6366f1;
            font-size: 32px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header .tagline {
            color: #6b7280;
            font-size: 14px;
            font-style: italic;
        }

        /* Ticket status badge */
        .status-badge {
            background-color: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
            font-size: 14px;
            margin: 20px 0;
        }

        /* Main ticket container */
        .ticket-container {
            border: 3px solid #e5e7eb;
            border-radius: 8px;
            padding: 0;
            margin: 20px 0;
            background-color: #ffffff;
        }

        /* Event section */
        .event-section {
            background-color: #667eea; /* Solide paarse kleur - gradients werken niet in DOMPDF */
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .event-section h2 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .event-details {
            margin-top: 15px;
        }

        .event-detail-item {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .event-detail-item strong {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }

        /* Order info section */
        .order-section {
            padding: 20px;
            background-color: #f9fafb;
        }

        .order-section h3 {
            color: #374151;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 8px 0;
            font-size: 13px;
        }

        .info-table td:first-child {
            color: #6b7280;
            width: 40%;
        }

        .info-table td:last-child {
            color: #111827;
            font-weight: 600;
        }

        /* Pricing section */
        .pricing-section {
            padding: 15px 20px;
            background-color: #fff;
            border-top: 1px solid #e5e7eb;
        }

        .pricing-table {
            width: 100%;
        }

        .pricing-table td {
            padding: 6px 0;
            font-size: 13px;
        }

        .pricing-table td:first-child {
            color: #6b7280;
        }

        .pricing-table td:last-child {
            text-align: right;
            font-weight: 600;
            color: #111827;
        }

        .pricing-table .total-row td {
            border-top: 2px solid #e5e7eb;
            padding-top: 12px;
            margin-top: 8px;
            font-size: 16px;
            font-weight: bold;
            color: #111827;
        }

        /* QR Code section */
        .qr-section {
            text-align: center;
            padding: 25px 20px;
            background-color: #f9fafb;
            border-top: 2px dashed #d1d5db;
        }

        .qr-section h3 {
            color: #374151;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .qr-code-container {
            background-color: white;
            padding: 20px;
            display: inline-block;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
        }

        .qr-code-container img {
            display: block;
            margin: 0 auto;
        }

        .order-number {
            font-size: 18px;
            font-weight: bold;
            color: #6366f1;
            margin-top: 15px;
            letter-spacing: 2px;
        }

        /* Footer instructions */
        .footer {
            margin-top: 30px;
            padding: 20px;
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
        }

        .footer h4 {
            color: #92400e;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .footer ul {
            margin-left: 20px;
            color: #78350f;
        }

        .footer li {
            margin-bottom: 6px;
            font-size: 12px;
        }

        /* Bottom branding */
        .bottom-info {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            color: #9ca3af;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>FestiTickets</h1>
        </div>

        <div style="text-align: center;">
            <span class="status-badge">✓ GELDIG TICKET</span>
        </div>

        <!-- Main Ticket -->
        <div class="ticket-container">
            <!-- Event Information -->
            <div class="event-section">
                <h2>{{ $order->event->name }}</h2>
                <div class="event-details">
                    <div class="event-detail-item">
                        <strong>Locatie:</strong> {{ $order->event->location }}
                    </div>
                    <div class="event-detail-item">
                        <strong>Datum:</strong> {{ $order->event->date->format('l d F Y') }}
                    </div>
                    <div class="event-detail-item">
                        <strong>Tijd:</strong> {{ $order->event->date->format('H:i') }} uur
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="order-section">
                <h3>Bestelgegevens</h3>
                <table class="info-table">
                    <tr>
                        <td>Bestelnummer:</td>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td>Klantnaam:</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td>E-mailadres:</td>
                        <td>{{ $order->user->email }}</td>
                    </tr>
                    <tr>
                        <td>Aantal tickets:</td>
                        <td>{{ $order->quantity }} {{ Str::plural('ticket', $order->quantity) }}</td>
                    </tr>
                    <tr>
                        <td>Besteldatum:</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <!-- Pricing Information -->
            <div class="pricing-section">
                <table class="pricing-table">
                    <tr>
                        <td>Ticketprijs ({{ $order->quantity }}x €{{ number_format($order->ticket_price, 2, ',', '.') }}):</td>
                        <td>€{{ number_format($order->ticket_price * $order->quantity, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Servicekosten (2.5%):</td>
                        <td>€{{ number_format($order->service_fee, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>Totaalbedrag:</td>
                        <td>€{{ number_format($order->total_amount, 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <h3>Toon deze QR-code bij de ingang</h3>
                <div class="qr-code-container">
                    <!-- QR Code wordt hier ingevoegd -->
                    {!! $qrCode !!}
                </div>
                <div class="order-number">
                    {{ $order->order_number }}
                </div>
            </div>
        </div>

        <!-- Important Instructions -->
        <div class="footer">
            <h4>Belangrijke informatie:</h4>
            <ul>
                <li>Bewaar dit ticket zorgvuldig. Je hebt het nodig voor toegang tot het evenement.</li>
                <li>Toon de QR-code bij de ingang op je telefoon of in print.</li>
                <li>Elk ticket is uniek en kan maar één keer gescand worden.</li>
                <li>Kom op tijd! Deuren sluiten {{ $order->event->date->format('H:i') }} uur.</li>
                <li>Bij verlies of diefstal kun je het ticket opnieuw downloaden vanaf je account.</li>
            </ul>
        </div>

        <!-- Bottom Information -->
        <div class="bottom-info">
            <p>© {{ date('Y') }} FestiTickets - Ticket gegenereerd op {{ now()->format('d-m-Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
