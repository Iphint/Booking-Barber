<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed – Invictocutz</title>
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
        .icon { font-size: 3rem; margin-bottom: 1.5rem; }
        h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 0.5rem; }
        .subtitle { color: #888; margin-bottom: 2rem; }
        .details {
            background: #222;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: left;
            margin-bottom: 2rem;
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
        .detail-row span:last-child { color: #FAFAF8; font-weight: 500; }
        .amount { color: #C9A96E !important; font-family: 'Playfair Display', serif; font-size: 1.1rem !important; }
        .btn {
            display: inline-block;
            background: #C9A96E;
            color: #0A0A0A;
            text-decoration: none;
            padding: 0.9rem 2.5rem;
            border-radius: 4px;
            font-weight: 500;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✅</div>
        <h1>Booking Confirmed!</h1>
        <p class="subtitle">Your appointment has been successfully booked and paid.</p>

        @if($booking)
        <div class="details">
            <div class="detail-row"><span>Order ID</span><span>{{ $booking->order_id }}</span></div>
            <div class="detail-row"><span>Name</span><span>{{ $booking->name }}</span></div>
            <div class="detail-row"><span>Service</span><span>{{ $booking->service }}</span></div>
            <div class="detail-row"><span>Barber</span><span>{{ $booking->barber }}</span></div>
            <div class="detail-row"><span>Date</span><span>{{ $booking->formatted_date }}</span></div>
            <div class="detail-row"><span>Time</span><span>{{ $booking->appointment_time }}</span></div>
            <div class="detail-row"><span>Total Paid</span><span class="amount">{{ $booking->formatted_amount }}</span></div>
        </div>
        @endif

        <a href="/" class="btn">Back to Home</a>
    </div>
</body>
</html>