<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invictocutz Barbershop – Premium Grooming</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- ===================== NAVBAR ===================== -->
<nav class="navbar" id="navbar">
    <div class="container nav-inner">
        <a href="#" class="nav-logo">
            <span class="logo-icon">✦</span>
            <span>INVICTOCUTZ</span>
        </a>
        <ul class="nav-links">
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#pricing">Pricing</a></li>
            <li><a href="#location">Location</a></li>
        </ul>
        <a href="#booking" class="nav-cta">Book Now</a>
        <button class="hamburger" id="hamburger"><i class="fas fa-bars"></i></button>
    </div>
</nav>

<!-- ===================== HERO ===================== -->
<section class="hero" id="home">
    <div class="hero-bg">
        <div class="hero-grain"></div>
        <div class="hero-lines"></div>
    </div>
    <div class="container hero-content">
        <div class="hero-badge">Est. 2024 &nbsp;·&nbsp; Premium Barbershop</div>
        <h1 class="hero-title">
            The Art of<br>
            <em>Precision</em> Cuts
        </h1>
        <p class="hero-sub">Expert grooming with modern technique. Walk in looking good, walk out looking <strong>unforgettable</strong>.</p>
        <div class="hero-meta">
            <span><i class="far fa-clock"></i> Mon – Sun &nbsp;·&nbsp; 09:00 – 19:00</span>
        </div>
        <div class="hero-actions">
            <a href="#booking" class="btn-primary">Book an Appointment</a>
            <a href="#services" class="btn-ghost">Explore Services</a>
        </div>
    </div>
    <div class="hero-scroll">
        <span></span>
        <p>Scroll</p>
    </div>
</section>

<!-- ===================== MARQUEE ===================== -->
<div class="marquee-wrap">
    <div class="marquee-track">
        <span>Fade &nbsp;·&nbsp;</span><span>Taper &nbsp;·&nbsp;</span><span>Mullet &nbsp;·&nbsp;</span>
        <span>Burst Fade &nbsp;·&nbsp;</span><span>Long Trim &nbsp;·&nbsp;</span><span>Beard Styling &nbsp;·&nbsp;</span>
        <span>Hair Color &nbsp;·&nbsp;</span><span>Perming &nbsp;·&nbsp;</span>
        <span>Fade &nbsp;·&nbsp;</span><span>Taper &nbsp;·&nbsp;</span><span>Mullet &nbsp;·&nbsp;</span>
        <span>Burst Fade &nbsp;·&nbsp;</span><span>Long Trim &nbsp;·&nbsp;</span><span>Beard Styling &nbsp;·&nbsp;</span>
        <span>Hair Color &nbsp;·&nbsp;</span><span>Perming &nbsp;·&nbsp;</span>
    </div>
</div>

<!-- ===================== ABOUT ===================== -->
<section class="about section" id="about">
    <div class="container about-grid">
        <div class="about-visual">
            <div class="about-img-wrap">
                <img src="{{ asset('assets/images.svg') }}" alt="Barbershop Interior">
                <div class="about-tag"><span>★ 5.0</span> Customer Rating</div>
            </div>
            <div class="about-stat-grid">
                <div class="stat-card"><span class="stat-num">500+</span><span class="stat-label">Clients Served</span></div>
                <div class="stat-card"><span class="stat-num">2</span><span class="stat-label">Expert Barbers</span></div>
                <div class="stat-card"><span class="stat-num">5+</span><span class="stat-label">Cut Styles</span></div>
            </div>
        </div>

        <div class="about-text">
            <p class="section-label">Who We Are</p>
            <h2 class="section-title">More Than a Haircut –<br>It's an <em>Experience</em></h2>
            <p class="about-body">Invictocutz Barbershop brings you professional grooming with modern techniques and precision results. Every visit is tailored to you — your style, your confidence.</p>
            <div class="barber-list">
                <div class="barber-item">
                    <div class="barber-avatar">D</div>
                    <div>
                        <strong>Dawam</strong>
                        <p>Senior Barber · Fade Specialist</p>
                    </div>
                </div>
                <div class="barber-item">
                    <div class="barber-avatar">C</div>
                    <div>
                        <strong>Cipta</strong>
                        <p>Senior Barber · Style Specialist</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== SERVICES (CUT TYPES) ===================== -->
<section class="services section" id="services">
    <div class="container">
        <div class="section-header">
            <p class="section-label">What We Offer</p>
            <h2 class="section-title">Our Signature <em>Cuts</em></h2>
        </div>
        <div class="cuts-grid">
            @php
                $cuts = [
                    ['Fade', 'The classic gradual taper. Clean, sharp, and timeless.', 'corte1.png'],
                    ['Taper', 'Subtle blend from long to short. Natural and refined.', 'corte2.png'],
                    ['Long Trim', 'Shape and texture for longer locks.', 'corte3.png'],
                    ['Mullet', 'Business in the front, party in the back.', 'corte1.png'],
                    ['Burst Fade', 'Semicircular fade behind the ear. Bold and modern.', 'corte2.png'],
                ];
            @endphp
            @foreach($cuts as $i => $cut)
            <div class="cut-card" style="--delay: {{ $i * 0.1 }}s">
                <div class="cut-img-wrap">
                    <img src="{{ asset('assets/' . $cut[2]) }}" alt="{{ $cut[0] }}">
                    <div class="cut-overlay">
                        <a href="#booking" class="btn-sm">Book This Cut</a>
                    </div>
                </div>
                <div class="cut-info">
                    <strong>{{ $cut[0] }}</strong>
                    <p>{{ $cut[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== PRICING ===================== -->
<section class="pricing section" id="pricing">
    <div class="container">
        <div class="section-header">
            <p class="section-label">Transparent Pricing</p>
            <h2 class="section-title">Simple. Fair. <em>Worth Every Rupiah.</em></h2>
        </div>
        <div class="price-grid">
            @php
                $prices = [
                    ['Haircut', 50000, 'fas fa-cut', 'Shape, fade, trim — all included.', false],
                    ['Beard Trim', 50000, 'fas fa-user', 'Clean lines, sharp edges.', false],
                    ['Hair Wash', 25000, 'fas fa-tint', 'Refresh with premium shampoo.', false],
                    ['Hair Color', 200000, 'fas fa-palette', 'Express yourself in full color.', true],
                    ['Perming', 200000, 'fas fa-wind', 'Curls and texture redefined.', true],
                ];
            @endphp
            @foreach($prices as $price)
            <div class="price-card {{ $price[3] ? 'featured' : '' }}">
                @if($price[3])<div class="price-badge">Popular</div>@endif
                <div class="price-icon"><i class="{{ $price[2] }}"></i></div>
                <h3 class="price-name">{{ $price[0] }}</h3>
                <p class="price-desc">{{ $price[4] }}</p>
                <div class="price-amount">Rp {{ number_format($price[1], 0, ',', '.') }}</div>
                <a href="#booking" class="btn-price">Book Now</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== BOOKING ===================== -->
<section class="booking-section section" id="booking">
    <div class="container">
        <div class="section-header">
            <p class="section-label">Ready for a Fresh Look?</p>
            <h2 class="section-title">Book Your <em>Appointment</em></h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="booking-wrap">
            <form class="booking-form" id="bookingForm" action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" placeholder="Your Name" required value="{{ old('name') }}">
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" placeholder="08xx-xxxx-xxxx" required value="{{ old('phone') }}">
                        @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Select Barber</label>
                        <select name="barber" required>
                            <option value="">— Choose Barber —</option>
                            <option value="Dawam" {{ old('barber') == 'Dawam' ? 'selected' : '' }}>Dawam</option>
                            <option value="Cipta" {{ old('barber') == 'Cipta' ? 'selected' : '' }}>Cipta</option>
                        </select>
                        @error('barber')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Multi-select Services --}}
                <div class="form-group">
                    <label>Services <span style="color:var(--gold);font-size:0.7rem;letter-spacing:0.05em;">(Select one or more)</span></label>
                    @php
                        $serviceList = [
                            'Haircut'    => ['price' => 50000,  'icon' => 'fas fa-cut',     'desc' => 'Shape, fade & trim'],
                            'Beard Trim' => ['price' => 50000,  'icon' => 'fas fa-user',    'desc' => 'Clean lines & edges'],
                            'Hair Wash'  => ['price' => 25000,  'icon' => 'fas fa-tint',    'desc' => 'Premium shampoo'],
                            'Hair Color' => ['price' => 200000, 'icon' => 'fas fa-palette', 'desc' => 'Full color treatment'],
                            'Perming'    => ['price' => 200000, 'icon' => 'fas fa-wind',    'desc' => 'Curls & texture'],
                        ];
                        $oldServices = old('services', []);
                    @endphp

                    <div class="service-cards" id="serviceCards">
                        @foreach($serviceList as $name => $info)
                        <div class="service-card {{ in_array($name, $oldServices) ? 'selected' : '' }}"
                             data-service="{{ $name }}"
                             data-price="{{ $info['price'] }}"
                             onclick="toggleService(this)">
                            <input type="checkbox"
                                   name="services[]"
                                   value="{{ $name }}"
                                   {{ in_array($name, $oldServices) ? 'checked' : '' }}
                                   style="display:none;">
                            <div class="sc-icon"><i class="{{ $info['icon'] }}"></i></div>
                            <div class="sc-info">
                                <strong>{{ $name }}</strong>
                                <span>{{ $info['desc'] }}</span>
                            </div>
                            <div class="sc-price">Rp {{ number_format($info['price'], 0, ',', '.') }}</div>
                            <div class="sc-check"><i class="fas fa-check"></i></div>
                        </div>
                        @endforeach
                    </div>
                    @error('services')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Appointment Date</label>
                        <input type="date" name="date" required min="{{ date('Y-m-d') }}" value="{{ old('date') }}">
                        @error('date')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Preferred Time</label>
                        <select name="time" required>
                            <option value="">— Select Time —</option>
                            @foreach(['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00', '19:00', '20:00', '21:00'] as $t)
                                <option value="{{ $t }}" {{ old('time') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('time')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Notes (Optional)</label>
                    <textarea name="notes" placeholder="Any special requests or references...">{{ old('notes') }}</textarea>
                </div>

                <div class="booking-summary" id="bookingSummary" style="display:none;">
                    <div id="summaryServiceList"></div>
                    <div class="summary-row total">
                        <span>Total</span><span id="summaryPrice">–</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="payBtn">
                    <i class="fas fa-lock"></i> Confirm & Pay
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ===================== AVAILABLE SCHEDULE ===================== -->
<section class="schedule section" id="schedule">
    <div class="container">
        <div class="section-header">
            <p class="section-label">Live Availability</p>
            <h2 class="section-title">Check Available <em>Schedules</em></h2>
        </div>

        {{-- Filter Bar --}}
        <div class="schedule-filter">
            <div class="filter-group">
                <label><i class="far fa-calendar"></i> Date</label>
                <input type="date" id="filterDate" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-cut"></i> Barber</label>
                <select id="filterBarber">
                    <option value="">All Barbers</option>
                    <option value="Dawam">Dawam</option>
                    <option value="Cipta">Cipta</option>
                </select>
            </div>
            <button class="btn-filter" id="checkScheduleBtn">
                <i class="fas fa-search"></i> Check Availability
            </button>
        </div>

        {{-- Schedule Grid --}}
        <div class="schedule-wrap" id="scheduleWrap">
            {{-- Dawam --}}
            <div class="barber-schedule" id="schedule-Dawam">
                <div class="barber-schedule-header">
                    <div class="barber-avatar-sm">D</div>
                    <div>
                        <strong>Dawam</strong>
                        <span>Fade Specialist</span>
                    </div>
                </div>
                <div class="time-slots" id="slots-Dawam">
                    <div class="slots-loading"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
                </div>
            </div>

            {{-- Cipta --}}
            <div class="barber-schedule" id="schedule-Cipta">
                <div class="barber-schedule-header">
                    <div class="barber-avatar-sm">C</div>
                    <div>
                        <strong>Cipta</strong>
                        <span>Style Specialist</span>
                    </div>
                </div>
                <div class="time-slots" id="slots-Cipta">
                    <div class="slots-loading"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="schedule-legend">
            <span><span class="legend-dot available"></span> Available</span>
            <span><span class="legend-dot booked"></span> Booked</span>
            <span><span class="legend-dot selected"></span> Selected</span>
        </div>
    </div>
</section>

<!-- ===================== LOCATION ===================== -->
<section class="location section" id="location">
    <div class="container">
        <div class="section-header">
            <p class="section-label">Find Us</p>
            <h2 class="section-title">Come Visit <em>The Shop</em></h2>
        </div>
        <div class="location-wrap">
            <div class="location-info">
                <div class="loc-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Address</strong>
                        <p>Jl. Contoh No. 123, Kota Anda</p>
                    </div>
                </div>
                <div class="loc-item">
                    <i class="far fa-clock"></i>
                    <div>
                        <strong>Opening Hours</strong>
                        <p>Monday – Sunday, 09:00 – 19:00</p>
                    </div>
                </div>
                <div class="loc-item">
                    <i class="fab fa-whatsapp"></i>
                    <div>
                        <strong>WhatsApp</strong>
                        <p>+62 800 0000 0000</p>
                    </div>
                </div>
                <a href="https://api.whatsapp.com/send?phone=6280000000000&text=Hi%2C%20I%20want%20to%20book%20an%20appointment"
                   target="_blank" class="btn-primary" style="margin-top:1.5rem; display:inline-block;">
                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>
            </div>
            <div class="map-embed">
                <iframe width="100%" height="100%" style="border:0;" loading="lazy" allowfullscreen
                    src="https://www.google.com/maps?q=Invictocutz%20Barbershop&output=embed">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- ===================== FOOTER ===================== -->
<footer class="footer">
    <div class="container footer-inner">
        <div class="footer-brand">
            <span class="logo-icon">✦</span>
            <span class="footer-name">INVICTOCUTZ</span>
            <p>Premium Grooming Experience</p>
        </div>
        <div class="footer-links">
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#pricing">Pricing</a>
            <a href="#schedule">Schedule</a>
            <a href="#booking">Book Now</a>
        </div>
        <p class="footer-copy">© 2026 Invictocutz Barbershop. All Rights Reserved.</p>
    </div>
</footer>

<!-- WhatsApp Float -->
<a href="https://api.whatsapp.com/send?phone=6280000000000&text=Hi%2C%20I%20want%20to%20book" class="wa-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
    <span>Book Now</span>
</a>

<script>
// ── Navbar scroll ────────────────────────────────────────
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
});

// ── Hamburger ────────────────────────────────────────────
document.getElementById('hamburger').addEventListener('click', () => {
    document.querySelector('.nav-links').classList.toggle('open');
});

// ── Multi-select Service Cards ────────────────────────────
function toggleService(card) {
    card.classList.toggle('selected');
    const cb = card.querySelector('input[type="checkbox"]');
    cb.checked = card.classList.contains('selected');
    updateSummary();
}

function updateSummary() {
    const selected = document.querySelectorAll('.service-card.selected');
    const summary  = document.getElementById('bookingSummary');
    const listEl   = document.getElementById('summaryServiceList');
    const priceEl  = document.getElementById('summaryPrice');

    if (selected.length === 0) {
        summary.style.display = 'none';
        return;
    }

    let total = 0;
    let html  = '';

    selected.forEach(card => {
        const name  = card.dataset.service;
        const price = parseInt(card.dataset.price);
        total += price;
        html += `<div class="summary-row">
            <span>${name}</span>
            <span>Rp ${price.toLocaleString('id-ID')}</span>
        </div>`;
    });

    listEl.innerHTML = html;
    priceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    summary.style.display = 'block';
}

// Init summary on load (for old() values)
document.addEventListener('DOMContentLoaded', updateSummary);

// ── Smooth scroll ────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
});

// ── Fade-in observer ─────────────────────────────────────
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.cut-card, .price-card, .stat-card, .barber-item').forEach(el => observer.observe(el));

// ── BOOKING FORM — AJAX + Midtrans Snap ──────────────────
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const btn = document.getElementById('payBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    fetch('{{ route("booking.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: new FormData(this),
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock"></i> Confirm & Pay';
            return;
        }
        // Trigger Midtrans Snap popup
        snap.pay(data.snap_token, {
            onSuccess: function(result) {
                window.location.href = '{{ route("booking.finish") }}?order_id=' + data.order_id;
            },
            onPending: function(result) {
                window.location.href = '{{ route("booking.pending") }}?order_id=' + data.order_id;
            },
            onError: function(result) {
                window.location.href = '{{ route("booking.error") }}?order_id=' + data.order_id;
            },
            onClose: function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock"></i> Confirm & Pay';
            }
        });
    })
    .catch(() => {
        alert('Something went wrong. Please try again.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-lock"></i> Confirm & Pay';
    });
});

// ── SCHEDULE CHECKER ─────────────────────────────────────
const allSlots = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00'];

function loadSchedule() {
    const date   = document.getElementById('filterDate').value;
    const barber = document.getElementById('filterBarber').value;

    if (!date) return;

    // Show/hide barber cards based on filter
    ['Dawam','Cipta'].forEach(b => {
        const card = document.getElementById('schedule-' + b);
        card.style.display = (!barber || barber === b) ? 'block' : 'none';
        document.getElementById('slots-' + b).innerHTML =
            '<div class="slots-loading"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
    });

    fetch(`{{ route('schedule.check') }}?date=${date}&barber=${barber}`)
        .then(res => res.json())
        .then(data => {
            // data = { Dawam: ['09:00','10:00'], Cipta: ['11:00'] } — booked slots
            ['Dawam','Cipta'].forEach(b => {
                if (barber && barber !== b) return;
                const bookedSlots = data[b] || [];
                const container   = document.getElementById('slots-' + b);
                container.innerHTML = '';

                allSlots.forEach(slot => {
                    const isBooked = bookedSlots.includes(slot);
                    const btn = document.createElement('button');
                    btn.className  = 'slot-btn ' + (isBooked ? 'booked' : 'available');
                    btn.textContent = slot;
                    btn.disabled   = isBooked;

                    if (!isBooked) {
                        btn.addEventListener('click', () => {
                            // Deselect semua slot
                            document.querySelectorAll('.slot-btn.selected').forEach(s => s.classList.remove('selected'));
                            btn.classList.add('selected');

                            // Auto-fill form booking
                            document.getElementById('booking').scrollIntoView({ behavior: 'smooth' });
                            const dateInput   = document.querySelector('[name="date"]');
                            const timeSelect  = document.querySelector('[name="time"]');
                            const barberSelect = document.querySelector('[name="barber"]');
                            if (dateInput)    dateInput.value  = date;
                            if (timeSelect)   timeSelect.value = slot;
                            if (barberSelect && b) barberSelect.value = b;

                            // Trigger summary update
                            updateSummary();
                        });
                    }

                    container.appendChild(btn);
                });
            });
        })
        .catch(() => {
            ['Dawam','Cipta'].forEach(b => {
                if (barber && barber !== b) return;
                document.getElementById('slots-' + b).innerHTML =
                    '<p style="color:#888;font-size:0.85rem;">Failed to load. Try again.</p>';
            });
        });
}

// Load on page ready
document.addEventListener('DOMContentLoaded', loadSchedule);

// Load on button click
document.getElementById('checkScheduleBtn').addEventListener('click', loadSchedule);

// Load on date change
document.getElementById('filterDate').addEventListener('change', loadSchedule);
document.getElementById('filterBarber').addEventListener('change', loadSchedule);
</script>
</body>
</html>