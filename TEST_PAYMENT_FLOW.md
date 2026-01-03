# End-to-End Payment Flow Test ✅

## Test Datum: 3 januari 2026

### Volledige Flow Verificatie

#### ✅ 1. Mollie Payment Integration
- **Status**: Werkend
- **Test API Key**: Geconfigureerd in `.env`
- **Checkout**: Redirect naar Mollie werkt
- **Return URL**: Payment status wordt correct afgehandeld
- **Webhook**: Disabled voor localhost (productie ready)

#### ✅ 2. PDF Ticket Generatie
- **DOMPDF**: v3.1.1 geïnstalleerd
- **Template**: [resources/views/pdf/ticket.blade.php](resources/views/pdf/ticket.blade.php)
- **Features**:
  - QR code met order nummer (endroid/qr-code v6)
  - Event details (naam, datum, tijd, locatie)
  - Order informatie (bestelnummer, aantal, prijzen)
  - Professional styling (DOMPDF compatible - geen gradients/flexbox)
- **Storage**: `storage/app/tickets/ticket-{ORDER_NUMBER}.pdf`
- **Database**: `ticket_path` column in orders table

#### ✅ 3. Email Verzending
- **Mailable**: [app/Mail/OrderConfirmation.php](app/Mail/OrderConfirmation.php)
- **Template**: [resources/views/emails/order-confirmation.blade.php](resources/views/emails/order-confirmation.blade.php)
- **SMTP**: Mailpit op localhost:1025
- **Features**:
  - Professionele HTML email
  - PDF ticket als bijlage
  - Event en order details
  - Instructies voor QR code gebruik
- **Mailpit UI**: http://localhost:8025

#### ✅ 4. PDF Download Functionaliteit
- **Routes**:
  - `order.ticket.download` - Download PDF (force download)
  - `order.ticket.preview` - Preview in browser
- **Security**: User ownership check (user_id verification)
- **Regeneration**: PDF wordt opnieuw gegenereerd als bestand ontbreekt

#### ✅ 5. Admin Dashboard
- **Route**: `admin.payments.index`
- **Features**:
  - 4 statistieken cards (Totaal, Betaald, In behandeling, Mislukt)
  - Chart.js pie chart voor status verdeling
  - Payments tabel met paginatie
  - PDF preview link voor betaalde orders
- **PDF Preview**: `admin.payments.ticket.preview` - Opens in new tab

### Code Flow Diagram

```
Gebruiker checkout
    ↓
PaymentController::create()
    → Create Order (status: pending)
    → Create Mollie Payment
    → Redirect to Mollie
    ↓
Gebruiker betaalt via Mollie
    ↓
Mollie redirect terug
    ↓
PaymentController::return()
    → Get payment status from Mollie API
    → Update payment & order status
    → Decrement event tickets
    → generateTicketPdf()
        → Generate QR code (order_number)
        → Render PDF view
        → Save to storage/app/tickets/
        → Update order.ticket_path
    → Refresh order model
    → Send OrderConfirmation email
        → Load PDF from storage
        → Attach to email
        → Send via SMTP (Mailpit)
    → Redirect to success page
```

### Belangrijke Technical Details

#### QR Code Generatie (endroid/qr-code v6)
```php
$qrCode = new QrCode($order->order_number);
$writer = new PngWriter();
$result = $writer->write($qrCode);
$qrCodeHtml = '<img src="' . $result->getDataUri() . '" style="width: 250px; height: 250px;" />';
```
**Note**: v6 heeft complete API rewrite - geen Builder class, geen static methods

#### PDF Attachment Fix
```php
// Critical: refresh() resets relationships!
$order->refresh()->load(['user', 'event']);

// Use Storage facade consistently
Storage::path($this->order->ticket_path)
```

#### DOMPDF Limitations
- ❌ No `linear-gradient`
- ❌ No `flexbox` or `grid`
- ❌ Limited CSS3 support
- ✅ Use `background-color` solid colors
- ✅ Use table-based layouts
- ✅ Use inline styles for reliability

### Configuration Files

#### .env Settings
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="info@festitickets.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Service Fee Calculation
- **Percentage**: 2.5% of subtotal
- **Formula**: `$serviceFee = $subtotal * 0.025`

### Test Checklist

- [x] Mollie payment creation
- [x] Redirect to Mollie checkout
- [x] Payment status update
- [x] Ticket decrement
- [x] PDF generation with QR code
- [x] PDF saved to storage
- [x] Order.ticket_path updated
- [x] Email sent to user
- [x] PDF attached to email
- [x] Email received in Mailpit
- [x] PDF downloadable from email
- [x] PDF preview in browser works
- [x] Admin can view payments
- [x] Admin can preview PDFs
- [x] Chart.js stats display correctly

### Known Issues & Solutions

#### Issue 1: PDF niet als bijlage
**Oorzaak**: `refresh()` reset relationships, manual path construction incorrect
**Oplossing**: `$order->refresh()->load(['user', 'event'])` + `Storage::path()`

#### Issue 2: endroid/qr-code v6 errors
**Oorzaak**: Complete API rewrite in v6
**Oplossing**: Use simple constructor: `new QrCode($data)` + `PngWriter`

#### Issue 3: DOMPDF gradient white block
**Oorzaak**: DOMPDF doesn't support linear-gradient
**Oplossing**: Use solid `background-color` instead

### Production Readiness

#### Before Going Live:
1. ✅ Webhook geconfigureerd (disabled voor local)
2. ⚠️ Verander Mollie API key naar live key
3. ⚠️ Test webhook met ngrok/expose voor local testing
4. ⚠️ Configure proper email SMTP (niet Mailpit)
5. ⚠️ Set up proper storage backup
6. ⚠️ Configure queue for email sending
7. ⚠️ Add rate limiting op payment endpoints

### File Locations

**Controllers**:
- `app/Http/Controllers/PaymentController.php` - Customer payment flow
- `app/Http/Controllers/Admin/PaymentController.php` - Admin management

**Models**:
- `app/Models/Order.php` (with ticket_path)
- `app/Models/Payment.php`
- `app/Models/Event.php`

**Views**:
- `resources/views/pdf/ticket.blade.php` - PDF template
- `resources/views/emails/order-confirmation.blade.php` - Email template
- `resources/views/admin/payments/index.blade.php` - Admin dashboard

**Mail**:
- `app/Mail/OrderConfirmation.php` - Mailable class

**Routes**:
- Payment: `payment.create`, `payment.return`, `payment.webhook`
- Tickets: `order.ticket.download`, `order.ticket.preview`
- Admin: `admin.payments.index`, `admin.payments.show`, `admin.payments.ticket.preview`

**Migrations**:
- `2026_01_03_160033_add_ticket_path_to_orders_table.php`

### Success Criteria ✅

Alle onderstaande criteria zijn succesvol getest en werkend:

1. ✅ Gebruiker kan tickets kopen via Mollie
2. ✅ PDF wordt automatisch gegenereerd na betaling
3. ✅ PDF bevat werkende QR code met order nummer
4. ✅ Email wordt verzonden met PDF als bijlage
5. ✅ Gebruiker kan ticket downloaden/previewen
6. ✅ Admin kan alle betalingen zien met stats
7. ✅ Admin kan PDF's bekijken
8. ✅ Ticket count wordt correct gedecrement

## Conclusie

**Status**: ✅ VOLLEDIG WERKEND

De complete Mollie payment flow met PDF ticket generatie en email verzending is succesvol geïmplementeerd en getest. Alle functionaliteit werkt zoals verwacht.

**Laatst getest**: 3 januari 2026 @ 17:00
**Getest door**: Development Team
