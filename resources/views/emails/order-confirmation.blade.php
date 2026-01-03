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
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        .event-details {
            background-color: #f9fafb;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .event-details h2 {
            margin: 0 0 15px 0;
            color: #667eea;
            font-size: 22px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #6b7280;
        }
        .detail-value {
            color: #111827;
            font-weight: 500;
        }
        .order-info {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .order-info h3 {
            margin: 0 0 15px 0;
            color: #374151;
            font-size: 18px;
        }
        .total-amount {
            background-color: #ecfdf5;
            border: 2px solid #10b981;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }
        .total-amount .label {
            font-size: 14px;
            color: #059669;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .total-amount .amount {
            font-size: 32px;
            color: #047857;
            font-weight: 700;
        }
        .attachment-notice {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .attachment-notice p {
            margin: 0;
            color: #92400e;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
        }
        @media only screen and (max-width: 600px) {
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
            <h1>🎉 Ticket Bevestiging</h1>
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

            <!-- Event Details -->
            <div class="event-details">
                <h2>{{ $order->event->name }}</h2>
                <div class="detail-row">
                    <span class="detail-label">📅 Datum:</span>
                    <span class="detail-value">{{ $order->event->date->format('d-m-Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">⏰ Tijd:</span>
                    <span class="detail-value">{{ $order->event->date->format('H:i') }} uur</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">📍 Locatie:</span>
                    <span class="detail-value">{{ $order->event->location }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">🎫 Aantal tickets:</span>
                    <span class="detail-value">{{ $order->quantity }}</span>
                </div>
            </div>

            <!-- Order Information -->
            <div class="order-info">
                <h3>Bestelgegevens</h3>
                <div class="detail-row">
                    <span class="detail-label">Bestelnummer:</span>
                    <span class="detail-value">{{ $order->order_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tickets ({{ $order->quantity }}x €{{ number_format($order->ticket_price, 2, ',', '.') }}):</span>
                    <span class="detail-value">€{{ number_format($order->quantity * $order->ticket_price, 2, ',', '.') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Servicekosten:</span>
                    <span class="detail-value">€{{ number_format($order->service_fee, 2, ',', '.') }}</span>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="total-amount">
                <div class="label">TOTAAL BETAALD</div>
                <div class="amount">€{{ number_format($order->total_amount, 2, ',', '.') }}</div>
            </div>

            <!-- Attachment Notice -->
            <div class="attachment-notice">
                <p>
                    <strong>📎 Je ticket zit als PDF bijlage bij deze email.</strong><br>
                    Download de PDF en bewaar deze goed. Je hebt de QR code nodig bij de ingang van het evenement.
                </p>
            </div>

            <p>
                <strong>Belangrijke informatie:</strong>
            </p>
            <ul>
                <li>Neem de PDF (digitaal of geprint) mee naar het evenement</li>
                <li>De QR code op je ticket wordt gescand bij de ingang</li>
                <li>Kom op tijd om wachtrijen te vermijden</li>
                <li>Check de evenement website voor actuele informatie</li>
            </ul>

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
