<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Pending – Invictocutz</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #0A0A0A;
            color: #FAFAF8;
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            background: #1A1A1A;
            border: 1px solid rgba(201,169,110,0.2);
            border-radius: 16px;
            padding: 3rem 2.5rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.1); opacity: 0.7; }
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .subtitle { color: #888; margin-bottom: 2rem; line-height: 1.6; }

        .details {
            background: #222;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: left;
            margin-bottom: 1.5rem;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: 0.9rem;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-row span:first-child { color: #888; }
        .detail-row span:last-child  { color: #FAFAF8; font-weight: 500; }
        .amount { color: #C9A96E !important; font-family: 'Playfair Display', serif; font-size: 1.1rem !important; }

        .info-box {
            background: rgba(234,179,8,0.08);
            border: 1px solid rgba(234,179,8,0.25);
            border-radius: 8px;
            padding: 1rem 1.2rem;
            font-size: 0.85rem;
            color: #EAB308;
            margin-bottom: 2rem;
            text-align: left;
            line-height: 1.6;
        }
        .info-box strong { display: block; margin-bottom: 0.3rem; }

        .actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn {
            display: inline-block;
            padding: 0.85rem 2rem;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-primary { background: #C9A96E; color: #0A0A0A; }
        .btn-primary:hover { background: #E4C896; }
        .btn-ghost {
            background: transparent;
            color: #888;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-ghost:hover { border-color: #C9A96E; color: #C9A96E; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">⏳</div>
        <h1>Payment Pending</h1>
        <p class="subtitle">
            Your booking has been received but payment is still being processed.
            Please complete your payment before the deadline.
        </p>

        @if($booking)
        <div class="details">
            <div class="detail-row"><span>Order ID</span><span>{{ $booking->order_id }}</span></div>
            <div class="detail-row"><span>Name</span><span>{{ $booking->name }}</span></div>
            <div class="detail-row"><span>Service</span><span>{{ $booking->service }}</span></div>
            <div class="detail-row"><span>Caster</span><span>{{ $booking->barber }}</span></div>
            <div class="detail-row"><span>Date</span><span>{{ $booking->formatted_date }}</span></div>
            <div class="detail-row"><span>Time</span><span>{{ $booking->appointment_time }}</span></div>
            <div class="detail-row"><span>Total</span><span class="amount">{{ $booking->formatted_amount }}</span></div>
        </div>
        @endif

        <div class="info-box">
            <strong>⚠️ Payment not yet confirmed</strong>
            If you chose bank transfer or virtual account, please complete the payment within 24 hours.
            Your appointment slot will be held until then.
        </div>

        <div class="actions">
            <a href="https://api.whatsapp.com/send?phone=6280000000000&text=Hi%2C%20I%20have%20a%20pending%20payment%20for%20order%20{{ $booking->order_id ?? '' }}" target="_blank" class="btn btn-primary">
                Contact via WhatsApp
            </a>
            <a href="/" class="btn btn-ghost">Back to Home</a>
        </div>
    </div>
</body>
</html>