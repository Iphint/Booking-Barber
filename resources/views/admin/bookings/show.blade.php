@extends('admin.layouts.app')
@section('title', 'Booking Detail')
@section('page-title', 'Booking Detail')

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--muted);
        text-decoration: none;
        font-size: 0.82rem;
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }
    .back-link:hover { color: var(--gold); }

    .detail-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 1.5rem; }

    .card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }
    .card-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-title { font-size: 0.9rem; font-weight: 500; color: var(--white); }
    .card-title i { color: var(--gold); margin-right: 0.5rem; }
    .card-body { padding: 1.5rem; }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.9rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        gap: 1rem;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-key { font-size: 0.78rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; flex-shrink: 0; }
    .detail-val { font-size: 0.9rem; color: var(--white); font-weight: 400; text-align: right; }

    .order-id-box {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 0.6rem 1rem;
        font-family: monospace;
        font-size: 0.85rem;
        color: var(--gold);
        letter-spacing: 0.05em;
    }

    .badge-status {
        display: inline-block;
        padding: 0.3rem 0.9rem;
        border-radius: 2rem;
        font-size: 0.78rem;
        font-weight: 500;
    }
    .badge-paid      { background: rgba(80,200,120,0.12);  color: var(--success); }
    .badge-pending   { background: rgba(234,179,8,0.12);   color: var(--warning); }
    .badge-cancelled { background: rgba(255,107,107,0.12); color: var(--danger); }
    .badge-fraud     { background: rgba(255,107,107,0.12); color: var(--danger); }

    .amount-big {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 700;
        color: var(--gold);
        text-align: center;
        padding: 1.5rem 0;
        border-bottom: 1px solid var(--border);
        margin-bottom: 1rem;
    }

    /* Update Status Form */
    .status-form select {
        width: 100%;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        color: var(--white);
        padding: 0.75rem 1rem;
        font-family: var(--font-body);
        font-size: 0.9rem;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        margin-bottom: 1rem;
        transition: var(--transition);
    }
    .status-form select:focus { border-color: var(--gold); }
    .btn-update {
        width: 100%;
        background: var(--gold);
        color: var(--black);
        border: none;
        padding: 0.85rem;
        border-radius: var(--radius);
        font-family: var(--font-body);
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-update:hover { background: var(--gold-light); }

    .notes-box {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem;
        font-size: 0.88rem;
        color: var(--muted);
        font-style: italic;
        line-height: 1.6;
    }

    .timeline { display: flex; flex-direction: column; gap: 0.8rem; }
    .timeline-item { display: flex; gap: 1rem; align-items: flex-start; }
    .timeline-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        margin-top: 0.3rem;
        flex-shrink: 0;
    }
    .timeline-dot.gold   { background: var(--gold); }
    .timeline-dot.green  { background: var(--success); }
    .timeline-dot.yellow { background: var(--warning); }
    .timeline-dot.red    { background: var(--danger); }
    .timeline-info strong { display: block; font-size: 0.85rem; color: var(--white); }
    .timeline-info span   { font-size: 0.75rem; color: var(--muted); }

    .wa-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        background: #25D366;
        color: white;
        text-decoration: none;
        padding: 0.85rem;
        border-radius: var(--radius);
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 1rem;
        transition: var(--transition);
    }
    .wa-btn:hover { background: #20BD5A; }

    @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<a href="{{ route('admin.bookings.index') }}" class="back-link">
    <i class="fas fa-arrow-left"></i> Back to All Bookings
</a>

<div class="detail-grid">
    {{-- Left: Booking Info --}}
    <div style="display:flex;flex-direction:column;gap:1.5rem;">

        {{-- Customer & Booking Details --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user"></i> Booking Details</h3>
                <span class="badge-status badge-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="detail-key">Order ID</span>
                    <span class="order-id-box">{{ $booking->order_id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Customer</span>
                    <span class="detail-val">{{ $booking->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Phone</span>
                    <span class="detail-val">{{ $booking->phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Service</span>
                    <span class="detail-val">{{ $booking->service }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Barber</span>
                    <span class="detail-val" style="color:var(--gold);">{{ $booking->barber }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Appointment</span>
                    <span class="detail-val">{{ $booking->formatted_date }} at {{ substr($booking->appointment_time,0,5) }}</span>
                </div>
                @if($booking->notes)
                <div class="detail-row">
                    <span class="detail-key">Notes</span>
                    <div class="notes-box" style="text-align:left;">{{ $booking->notes }}</div>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-key">Booked At</span>
                    <span class="detail-val" style="color:var(--muted);">{{ $booking->created_at->format('d M Y, H:i') }}</span>
                </div>
                @if($booking->paid_at)
                <div class="detail-row">
                    <span class="detail-key">Paid At</span>
                    <span class="detail-val" style="color:var(--success);">{{ $booking->paid_at->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-credit-card"></i> Payment Info</h3>
            </div>
            <div class="card-body">
                <div class="amount-big">{{ $booking->formatted_amount }}</div>
                <div class="detail-row">
                    <span class="detail-key">Payment Method</span>
                    <span class="detail-val">{{ $booking->payment_type ? ucwords(str_replace('_',' ',$booking->payment_type)) : '–' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Status</span>
                    <span class="badge-status badge-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Actions --}}
    <div style="display:flex;flex-direction:column;gap:1.5rem;">

        {{-- Update Status --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit"></i> Update Status</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="status-form">
                    @csrf @method('PATCH')
                    <label style="font-size:0.75rem;color:var(--muted);letter-spacing:0.08em;text-transform:uppercase;display:block;margin-bottom:0.5rem;">
                        Payment Status
                    </label>
                    <select name="payment_status">
                        @foreach(['pending','paid','cancelled','fraud'] as $s)
                            <option value="{{ $s }}" {{ $booking->payment_status === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>

                {{-- WhatsApp Customer --}}
                @php
                    $waPhone = '62' . ltrim($booking->phone, '0');
                    $waMsg   = urlencode("Hi {$booking->name}, your booking at Invictocutz on {$booking->formatted_date} at " . substr($booking->appointment_time,0,5) . " is confirmed! 💈");
                @endphp
                <a href="https://api.whatsapp.com/send?phone={{ $waPhone }}&text={{ $waMsg }}" target="_blank" class="wa-btn">
                    <i class="fab fa-whatsapp"></i> Message Customer
                </a>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Activity</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot gold"></div>
                        <div class="timeline-info">
                            <strong>Booking Created</strong>
                            <span>{{ $booking->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    @if($booking->payment_status === 'paid')
                    <div class="timeline-item">
                        <div class="timeline-dot green"></div>
                        <div class="timeline-info">
                            <strong>Payment Confirmed</strong>
                            <span>{{ $booking->paid_at ? $booking->paid_at->format('d M Y, H:i') : 'Via webhook' }}</span>
                        </div>
                    </div>
                    @elseif($booking->payment_status === 'pending')
                    <div class="timeline-item">
                        <div class="timeline-dot yellow"></div>
                        <div class="timeline-info">
                            <strong>Awaiting Payment</strong>
                            <span>Customer has not completed payment</span>
                        </div>
                    </div>
                    @elseif($booking->payment_status === 'cancelled')
                    <div class="timeline-item">
                        <div class="timeline-dot red"></div>
                        <div class="timeline-info">
                            <strong>Booking Cancelled</strong>
                            <span>Payment was cancelled or expired</span>
                        </div>
                    </div>
                    @endif
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background:var(--border);"></div>
                        <div class="timeline-info">
                            <strong style="color:var(--muted);">Appointment</strong>
                            <span>{{ $booking->formatted_date }} at {{ substr($booking->appointment_time,0,5) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="card" style="border-color:rgba(255,107,107,0.15);">
            <div class="card-header" style="border-color:rgba(255,107,107,0.1);">
                <h3 class="card-title" style="color:var(--danger);"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
            </div>
            <div class="card-body">
                <p style="font-size:0.82rem;color:var(--muted);margin-bottom:1rem;">
                    Permanently delete this booking. This action cannot be undone.
                </p>
                <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                      onsubmit="return confirm('Are you sure you want to permanently delete this booking?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="width:100%;background:rgba(255,107,107,0.08);border:1px solid rgba(255,107,107,0.2);color:var(--danger);padding:0.75rem;border-radius:var(--radius);font-family:var(--font-body);font-size:0.82rem;cursor:pointer;transition:var(--transition);"
                        onmouseover="this.style.background='var(--danger)';this.style.color='white';"
                        onmouseout="this.style.background='rgba(255,107,107,0.08)';this.style.color='var(--danger)';">
                        <i class="fas fa-trash"></i> Delete Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection