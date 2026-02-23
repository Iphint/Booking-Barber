# Invictocutz Barbershop — Laravel + Midtrans Setup Guide

## File Structure
```
resources/views/
├── welcome.blade.php           ← Main landing page
├── booking/
│   ├── finish.blade.php        ← Payment success page
│   ├── pending.blade.php       ← Payment pending page (create similarly to finish)
│   └── error.blade.php         ← Payment error page (create similarly)
public/css/
└── style.css                   ← All styles
app/
├── Http/Controllers/BookingController.php
└── Models/Booking.php
config/midtrans.php
database/migrations/..._create_bookings_table.php
routes/web.php
```

## Step 1: Install Midtrans PHP SDK
```bash
composer require midtrans/midtrans-php
```

## Step 2: Publish config
Copy `config/midtrans.php` to your Laravel `config/` directory.

## Step 3: Add to .env
```env
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxxxxx
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```
> Get your keys from: https://dashboard.midtrans.com → Settings → Access Keys

## Step 4: Run migration
```bash
php artisan migrate
```

## Step 5: Set Midtrans webhook URL
In Midtrans Dashboard → Settings → Configuration:
- **Payment Notification URL**: `https://yourdomain.com/midtrans/notification`
- **Finish Redirect URL**: `https://yourdomain.com/booking/finish`
- **Error Redirect URL**: `https://yourdomain.com/booking/error`
- **Unfinish Redirect URL**: `https://yourdomain.com/booking/pending`

## Step 6: Update assets
Replace the placeholder `asset()` paths with your actual images:
- `assets/logo.svg`
- `assets/images.svg` (barbershop interior photo)
- `assets/corte1.png`, `corte2.png`, `corte3.png` (haircut reference images)
- `assets/whatssapp.svg` (optional, now using Font Awesome icon)

## Step 7: Update contact details
In `welcome.blade.php`, replace:
- `6280000000000` → your actual WhatsApp number
- Address in the location section

## How Payment Flow Works
1. Customer fills booking form → POST to `/booking`
2. Laravel saves booking, creates Midtrans Snap token
3. Redirect back with snap token in session
4. Midtrans popup appears automatically (handled by JS)
5. Customer pays via any method (GoPay, QRIS, bank transfer, etc.)
6. Midtrans sends webhook to `/midtrans/notification`
7. Laravel updates booking status to `paid`
8. Customer is redirected to `/booking/finish`

## Switch to Production
1. Change `.env`: `MIDTRANS_IS_PRODUCTION=true`
2. Use production keys (not SB- prefix)
3. Change Snap.js script in blade:
   - Sandbox: `app.sandbox.midtrans.com`
   - Production: `app.midtrans.com`

## Admin Panel
Visit `/admin/bookings` (requires auth) to see all bookings.
Add Laravel Breeze/Jetstream for authentication.

## Optional: WhatsApp Auto-notification
For automated WhatsApp messages on payment success, integrate:
- **Fonnte** (fonnte.com) — cheapest
- **WA Business Cloud API** (official Meta)
See the `sendWhatsappConfirmation()` method in BookingController.