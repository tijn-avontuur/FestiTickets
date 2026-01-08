<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bevestiging van je ticket</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 4px solid #6366f1;
            padding: 30px;
            background-color: #ffffff;
        }
        .header h1 {
            color: #6366f1;
            font-size: 32px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        .header .tagline {
            color: #6b7280;
            font-size: 14px;
            font-style: italic;
        }
        .status-badge {
            background-color: #10b981;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
            font-size: 14px;
            margin: 20px 0;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        .ticket-container {
            border: 3px solid #e5e7eb;
            border-radius: 8px;
            margin: 20px 0;
            overflow: hidden;
        }
        .event-section {
            background-color: #667eea;
            color: white;
            padding: 25px;
        }
        .event-section h2 {
            margin: 0 0 20px 0;
            font-size: 24px;
            font-weight: bold;
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
        .order-section {
            padding: 25px;
            background-color: #f9fafb;
        }
        .order-section h3 {
            color: #374151;
            font-size: 18px;
            margin: 0 0 15px 0;
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
            width: 45%;
        }
        .info-table td:last-child {
            color: #111827;
            font-weight: 600;
        }
        .pricing-section {
            padding: 20px 25px;
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
        .attachment-notice {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .attachment-notice h4 {
            color: #92400e;
            font-size: 14px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        .attachment-notice ul {
            margin: 10px 0 0 20px;
            color: #78350f;
        }
        .attachment-notice li {
            margin-bottom: 6px;
            font-size: 13px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            border-top: 2px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
        }
        @media only screen and (max-width: 700px) {
            .container {
                margin: 10px;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>FestiTickets</h1>
            <div class="tagline">Je ticket is bevestigd!</div>
        </div>

        <div style="text-align: center; padding: 0 30px;">
            <span class="status-badge">✓ BETALING GELUKT</span>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hoi {{ $order->user->name }},
            </div>

            <p>
                Bedankt voor je bestelling! Je betaling is succesvol verwerkt en je tickets zijn klaar.
                Je vindt je ticket als PDF bijlage bij deze email.
            </p>

            <!-- Ticket Container -->
            <div class="ticket-container">
                <!-- Event Details -->
                <div class="event-section">
                    <h2>{{ $order->event->name }}</h2>
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
            </div>

            <!-- Important Instructions -->
            <div class="attachment-notice">
                <h4>Belangrijk - Je PDF ticket:</h4>
                <ul>
                    <li>Bewaar dit ticket zorgvuldig. Je hebt het nodig voor toegang tot het evenement.</li>
                    <li>Toon de QR-code bij de ingang op je telefoon of in print.</li>
                    <li>Elk ticket is uniek en kan maar één keer gescand worden.</li>
                    <li>Kom op tijd! Deuren sluiten {{ $order->event->date->format('H:i') }} uur.</li>
                    <li>Bij verlies of diefstal kun je het ticket opnieuw downloaden vanaf je account.</li>
                </ul>
            </div>

            <p style="margin-top: 30px;">
                Heb je vragen over je bestelling? Neem dan contact met ons op.
            </p>

            <p>
                We wensen je alvast veel plezier!
            </p>

            <p style="margin-top: 20px;">
                Met vriendelijke groet,<br>
                <strong>Het FestiTickets Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Deze email is automatisch gegenereerd, reageren is niet mogelijk.</p>
            <p>&copy; {{ date('Y') }} FestiTickets. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>
</html>
