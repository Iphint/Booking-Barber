<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed – Invictocutz</title>
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
            border: 1px solid rgba(255, 107, 107, 0.2);
            border-radius: 16px;
            padding: 3rem 2.5rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            animation: shake 0.5s ease both;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%       { transform: translateX(-8px); }
            40%       { transform: translateX(8px); }
            60%       { transform: translateX(-5px); }
            80%       { transform: translateX(5px); }
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .subtitle { color: #888; margin-bottom: 2rem; line-height: 1.6; }

        .reasons {
            background: rgba(255,107,107,0.05);
            border: 1px solid rgba(255,107,107,0.15);
            border-radius: 8px;
            padding: 1.2rem 1.5rem;
            text-align: left;
            margin-bottom: 2rem;
        }
        .reasons p {
            font-size: 0.82rem;
            color: #888;
            margin-bottom: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .reasons ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .reasons ul li {
            font-size: 0.85rem;
            color: #aaa;
            padding-left: 1.2rem;
            position: relative;
        }
        .reasons ul li::before {
            content: '·';
            position: absolute;
            left: 0;
            color: #ff6b6b;
            font-size: 1.2rem;
            line-height: 1;
        }

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

        .help {
            margin-top: 2rem;
            font-size: 0.78rem;
            color: #555;
        }
        .help a { color: #C9A96E; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">❌</div>
        <h1>Payment Failed</h1>
        <p class="subtitle">
            Something went wrong during the payment process.
            Don't worry — your booking data is saved. Please try again.
        </p>

        <div class="reasons">
            <p>Possible reasons</p>
            <ul>
                <li>Insufficient balance or credit limit</li>
                <li>Card or account details were incorrect</li>
                <li>Transaction timed out or was cancelled</li>
                <li>Bank declined the transaction</li>
            </ul>
        </div>

        <div class="actions">
            <a href="/#booking" class="btn btn-primary">Try Again</a>
            <a href="https://api.whatsapp.com/send?phone=6280000000000&text=Hi%2C%20I%20had%20a%20payment%20issue%20and%20need%20help" target="_blank" class="btn btn-ghost">
                Contact Support
            </a>
        </div>

        <p class="help">
            Need help? Chat us on <a href="https://api.whatsapp.com/send?phone=6280000000000" target="_blank">WhatsApp</a>
            or email <a href="mailto:invictocutz@email.com">invictocutz@email.com</a>
        </p>
    </div>
</body>
</html>