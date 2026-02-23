<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – Invictocutz</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --gold: #C9A96E;
            --gold-light: #E4C896;
            --black: #0A0A0A;
            --dark: #111111;
            --dark-2: #1A1A1A;
            --dark-3: #222222;
            --white: #FAFAF8;
            --muted: #888888;
            --border: rgba(201,169,110,0.15);
            --danger: #ff6b6b;
            --font-display: 'Playfair Display', serif;
            --font-body: 'DM Sans', sans-serif;
            --radius: 6px;
            --transition: 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--black);
            color: var(--white);
            font-family: var(--font-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* ── Background effects ── */
        .bg-effects {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }
        .bg-glow-1 {
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(201,169,110,0.07) 0%, transparent 70%);
            top: -100px; right: -100px;
            border-radius: 50%;
        }
        .bg-glow-2 {
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(201,169,110,0.04) 0%, transparent 70%);
            bottom: -80px; left: -80px;
            border-radius: 50%;
        }
        .bg-lines {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                90deg,
                rgba(201,169,110,0.025) 0px,
                rgba(201,169,110,0.025) 1px,
                transparent 1px,
                transparent 80px
            ),
            repeating-linear-gradient(
                0deg,
                rgba(201,169,110,0.015) 0px,
                rgba(201,169,110,0.015) 1px,
                transparent 1px,
                transparent 80px
            );
        }
        .bg-grain {
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            background-size: 200px;
        }

        /* ── Login Card ── */
        .login-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
            animation: fadeUp 0.7s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Brand ── */
        .brand {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px; height: 60px;
            background: rgba(201,169,110,0.1);
            border: 1px solid var(--border);
            border-radius: 16px;
            font-size: 1.5rem;
            color: var(--gold);
            margin-bottom: 1.2rem;
        }
        .brand-name {
            display: block;
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: 0.1em;
            color: var(--white);
            margin-bottom: 0.3rem;
        }
        .brand-sub {
            font-size: 0.72rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold);
        }

        /* ── Card ── */
        .card {
            background: var(--dark-2);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.5rem;
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 0.3rem;
        }
        .card-subtitle {
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 1.3rem;
        }
        .form-group label {
            display: block;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.85rem;
            transition: var(--transition);
        }
        .input-wrap input {
            width: 100%;
            background: var(--dark-3);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--white);
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            font-family: var(--font-body);
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition);
        }
        .input-wrap input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,169,110,0.08);
        }
        .input-wrap input:focus + i,
        .input-wrap:focus-within i {
            color: var(--gold);
        }
        /* Fix icon order - icon after input for z-index trick */
        .input-wrap input::placeholder { color: rgba(255,255,255,0.2); }

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 0.85rem;
            padding: 0;
            transition: var(--transition);
        }
        .toggle-pw:hover { color: var(--gold); }

        .form-error {
            display: block;
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.4rem;
        }

        /* ── Remember & Forgot ── */
        .form-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.82rem;
            color: var(--muted);
        }
        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--gold);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 0.78rem;
            color: var(--muted);
            text-decoration: none;
            transition: var(--transition);
        }
        .forgot-link:hover { color: var(--gold); }

        /* ── Submit Button ── */
        .btn-submit {
            width: 100%;
            background: var(--gold);
            color: var(--black);
            border: none;
            padding: 0.95rem;
            border-radius: var(--radius);
            font-family: var(--font-body);
            font-size: 0.88rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
        }
        .btn-submit:hover {
            background: var(--gold-light);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(201,169,110,0.25);
        }
        .btn-submit:active { transform: translateY(0); }

        /* ── Session status ── */
        .session-status {
            background: rgba(80,200,120,0.08);
            border: 1px solid rgba(80,200,120,0.2);
            color: #50c878;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.82rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── Back to site ── */
        .back-site {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-site a {
            font-size: 0.78rem;
            color: var(--muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: var(--transition);
        }
        .back-site a:hover { color: var(--gold); }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span {
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
        }
    </style>
</head>
<body>

<div class="bg-effects">
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>
    <div class="bg-lines"></div>
    <div class="bg-grain"></div>
</div>

<div class="login-wrap">

    {{-- Brand --}}
    <div class="brand">
        <div class="brand-icon">✦</div>
        <span class="brand-name">INVICTOCUTZ</span>
        <span class="brand-sub">Admin Panel</span>
    </div>

    {{-- Card --}}
    <div class="card">
        <h1 class="card-title">Welcome back</h1>
        <p class="card-subtitle">Sign in to manage your barbershop</p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="session-status">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@invictocutz.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    <i class="fas fa-envelope"></i>
                </div>
                @error('email')
                    <span class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <i class="fas fa-lock"></i>
                    <button type="button" class="toggle-pw" id="togglePw" tabindex="-1">
                        <i class="fas fa-eye" id="togglePwIcon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            {{-- Remember & Forgot --}}
            <div class="form-bottom">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember_me">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Sign In to Admin
            </button>
        </form>
    </div>

    {{-- Back to site --}}
    <div class="back-site">
        <a href="{{ route('home') }}">
            <i class="fas fa-arrow-left"></i> Back to main site
        </a>
    </div>

</div>

<script>
// Toggle password visibility
document.getElementById('togglePw').addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('togglePwIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>

</body>
</html>