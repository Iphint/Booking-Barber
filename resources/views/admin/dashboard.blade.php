@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
    }
    .stat-card:hover { border-color: rgba(201,169,110,0.3); transform: translateY(-2px); }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: var(--radius-lg);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .stat-icon.gold    { background: rgba(201,169,110,0.12); color: var(--gold); }
    .stat-icon.green   { background: rgba(80,200,120,0.1);   color: var(--success); }
    .stat-icon.yellow  { background: rgba(234,179,8,0.1);    color: var(--warning); }
    .stat-icon.red     { background: rgba(255,107,107,0.1);  color: var(--danger); }
    .stat-num {
        font-family: var(--font-display);
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--white);
        line-height: 1;
        display: block;
    }
    .stat-label { font-size: 0.78rem; color: var(--muted); margin-top: 0.2rem; display: block; }
    .stat-sub   { font-size: 0.72rem; color: var(--muted); margin-top: 0.5rem; }
    .stat-sub span { color: var(--gold); }

    .grid-2 { display: grid; grid-template-columns: 1.6fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }

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
    .card-link {
        font-size: 0.75rem;
        color: var(--gold);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .card-link:hover { color: var(--gold-light); }

    /* Recent Bookings Table */
    .mini-table { width: 100%; border-collapse: collapse; }
    .mini-table th {
        text-align: left;
        font-size: 0.68rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 0 0 0.8rem;
        border-bottom: 1px solid var(--border);
        font-weight: 500;
    }
    .mini-table td {
        padding: 0.8rem 0;
        font-size: 0.85rem;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        vertical-align: middle;
    }
    .mini-table tr:last-child td { border-bottom: none; }
    .mini-table td:first-child { color: var(--white); font-weight: 500; }

    /* Status badges */
    .badge-status {
        display: inline-block;
        padding: 0.25rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 0.04em;
    }
    .badge-paid      { background: rgba(80,200,120,0.12);  color: var(--success); }
    .badge-pending   { background: rgba(234,179,8,0.12);   color: var(--warning); }
    .badge-cancelled { background: rgba(255,107,107,0.12); color: var(--danger); }
    .badge-fraud     { background: rgba(255,107,107,0.12); color: var(--danger); }

    /* Revenue chart bar */
    .revenue-bars { display: flex; align-items: flex-end; gap: 0.5rem; height: 120px; }
    .rev-bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.4rem; }
    .rev-bar {
        width: 100%;
        background: rgba(201,169,110,0.15);
        border-radius: 3px 3px 0 0;
        position: relative;
        min-height: 4px;
        transition: 0.6s ease;
    }
    .rev-bar.filled { background: var(--gold); }
    .rev-label { font-size: 0.65rem; color: var(--muted); }

    /* Today schedule */
    .today-list { display: flex; flex-direction: column; gap: 0.8rem; }
    .today-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem 1rem;
        background: var(--dark-3);
        border-radius: var(--radius);
        border: 1px solid var(--border);
    }
    .today-time {
        font-family: var(--font-display);
        font-size: 0.9rem;
        color: var(--gold);
        font-weight: 700;
        min-width: 50px;
    }
    .today-info strong { display: block; font-size: 0.85rem; color: var(--white); }
    .today-info span   { font-size: 0.75rem; color: var(--muted); }
    .today-barber {
        margin-left: auto;
        font-size: 0.72rem;
        background: rgba(201,169,110,0.1);
        color: var(--gold);
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
    }
    .empty-state {
        text-align: center;
        color: var(--muted);
        padding: 2rem;
        font-size: 0.88rem;
    }
    .empty-state i { font-size: 2rem; color: var(--border); display: block; margin-bottom: 0.8rem; }

    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 768px)  { .stats-grid { grid-template-columns: 1fr 1fr; } .grid-2 { grid-template-columns: 1fr; } }
    @media (max-width: 480px)  { .stats-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-calendar-check"></i></div>
        <div>
            <span class="stat-num">{{ $stats['total'] }}</span>
            <span class="stat-label">Total Bookings</span>
            <p class="stat-sub">Today: <span>{{ $stats['today'] }}</span></p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div>
            <span class="stat-num">{{ $stats['paid'] }}</span>
            <span class="stat-label">Paid Bookings</span>
            <p class="stat-sub">This month: <span>{{ $stats['paid_month'] }}</span></p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="fas fa-clock"></i></div>
        <div>
            <span class="stat-num">{{ $stats['pending'] }}</span>
            <span class="stat-label">Pending Payment</span>
            <p class="stat-sub">Needs attention</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-coins"></i></div>
        <div>
            <span class="stat-num">{{ $stats['revenue_formatted'] }}</span>
            <span class="stat-label">Total Revenue</span>
            <p class="stat-sub">This month: <span>{{ $stats['revenue_month_formatted'] }}</span></p>
        </div>
    </div>
</div>

{{-- Main Grid --}}
<div class="grid-2">
    {{-- Recent Bookings --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Recent Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="card-link">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body" style="padding:0;">
            @if($recentBookings->count())
            <table class="mini-table" style="padding:0 1.5rem;">
                <thead>
                    <tr style="padding:0 1.5rem;">
                        <th style="padding-left:1.5rem;">Customer</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $b)
                    <tr>
                        <td style="padding-left:1.5rem;">
                            <a href="{{ route('admin.bookings.show', $b) }}" style="color:var(--white);text-decoration:none;font-weight:500;">
                                {{ $b->name }}
                            </a>
                            <span style="display:block;font-size:0.72rem;color:var(--muted);">{{ $b->barber }}</span>
                        </td>
                        <td style="color:var(--muted);">{{ $b->service }}</td>
                        <td style="color:var(--muted);font-size:0.8rem;">{{ $b->formatted_date }}<br>{{ $b->appointment_time }}</td>
                        <td style="color:var(--gold);font-family:var(--font-display);">{{ $b->formatted_amount }}</td>
                        <td style="padding-right:1.5rem;">
                            <span class="badge-status badge-{{ $b->payment_status }}">
                                {{ ucfirst($b->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="empty-state"><i class="fas fa-calendar-times"></i> No bookings yet.</div>
            @endif
        </div>
    </div>

    {{-- Today's Schedule --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-day"></i> Today's Schedule</h3>
            <a href="{{ route('admin.schedule') }}" class="card-link">Full <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body">
            @if($todayBookings->count())
                <div class="today-list">
                    @foreach($todayBookings as $b)
                    <div class="today-item">
                        <span class="today-time">{{ substr($b->appointment_time, 0, 5) }}</span>
                        <div class="today-info">
                            <strong>{{ $b->name }}</strong>
                            <span>{{ $b->service }}</span>
                        </div>
                        <span class="today-barber">{{ $b->barber }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state"><i class="fas fa-coffee"></i> No bookings today.</div>
            @endif
        </div>
    </div>
</div>

{{-- Revenue by Barber --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-bar"></i> Revenue by Barber (This Month)</h3>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
            @foreach($revenueByBarber as $barber => $amount)
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:0.6rem;">
                    <span style="font-size:0.88rem;color:var(--white);font-weight:500;">{{ $barber }}</span>
                    <span style="font-size:0.88rem;color:var(--gold);font-family:var(--font-display);">
                        Rp {{ number_format($amount, 0, ',', '.') }}
                    </span>
                </div>
                @php
                    $maxRevenue = max(array_values($revenueByBarber->toArray()));
                    $pct = $maxRevenue > 0 ? ($amount / $maxRevenue * 100) : 0;
                @endphp
                <div style="background:rgba(201,169,110,0.1);border-radius:3px;height:8px;overflow:hidden;">
                    <div style="height:100%;width:{{ e($pct) }}%;background:var(--gold);border-radius:3px;transition:width 1s ease;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection