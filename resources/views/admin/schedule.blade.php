@extends('admin.layouts.app')
@section('title', 'Schedule')
@section('page-title', 'Today\'s Schedule')

@push('styles')
<style>
    .schedule-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .date-picker-wrap {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .date-picker-wrap input {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        color: var(--white);
        padding: 0.65rem 1rem;
        font-family: var(--font-body);
        font-size: 0.88rem;
        outline: none;
        transition: var(--transition);
    }
    .date-picker-wrap input:focus { border-color: var(--gold); }
    .btn-sm-gold {
        background: var(--gold);
        color: var(--black);
        border: none;
        padding: 0.65rem 1.2rem;
        border-radius: var(--radius);
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        font-family: var(--font-body);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .btn-sm-gold:hover { background: var(--gold-light); }

    .schedule-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .barber-col {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }
    .barber-col-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .barber-avatar {
        width: 40px; height: 40px;
        background: var(--gold);
        color: var(--black);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }
    .barber-col-header strong { display: block; color: var(--white); font-size: 0.95rem; }
    .barber-col-header span   { font-size: 0.72rem; color: var(--muted); }
    .barber-stats {
        margin-left: auto;
        text-align: right;
        font-size: 0.75rem;
    }
    .barber-stats .booked-count { color: var(--gold); font-weight: 600; font-size: 1rem; }
    .barber-stats .avail-count  { color: var(--muted); }

    .slot-list { padding: 1rem; display: flex; flex-direction: column; gap: 0.6rem; }

    .slot-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem 1rem;
        border-radius: var(--radius);
        border: 1px solid transparent;
        transition: var(--transition);
    }
    .slot-item.booked {
        background: rgba(201,169,110,0.05);
        border-color: var(--border);
    }
    .slot-item.available {
        background: rgba(255,255,255,0.02);
        border-color: rgba(255,255,255,0.04);
    }
    .slot-time {
        font-family: var(--font-display);
        font-size: 0.95rem;
        font-weight: 700;
        min-width: 52px;
    }
    .slot-item.booked .slot-time   { color: var(--gold); }
    .slot-item.available .slot-time { color: rgba(255,255,255,0.2); }

    .slot-customer strong { display: block; font-size: 0.85rem; color: var(--white); }
    .slot-customer span   { font-size: 0.72rem; color: var(--muted); }
    .slot-available-label { font-size: 0.75rem; color: rgba(255,255,255,0.15); font-style: italic; }

    .slot-badge {
        margin-left: auto;
        font-size: 0.7rem;
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
    }
    .badge-paid      { background: rgba(80,200,120,0.12);  color: var(--success); }
    .badge-pending   { background: rgba(234,179,8,0.12);   color: var(--warning); }
    .badge-cancelled { background: rgba(255,107,107,0.12); color: var(--danger); }

    .view-link {
        font-size: 0.72rem;
        color: var(--gold);
        text-decoration: none;
        margin-left: 0.5rem;
        opacity: 0;
        transition: var(--transition);
    }
    .slot-item:hover .view-link { opacity: 1; }

    @media (max-width: 768px) { .schedule-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<div class="schedule-header">
    <div>
        <p style="font-size:0.78rem;color:var(--muted);margin-bottom:0.2rem;">Showing schedule for</p>
        <h2 style="font-family:var(--font-display);font-size:1.4rem;color:var(--white);">
            {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
            @if($date === date('Y-m-d'))
                <span style="font-size:0.75rem;background:rgba(201,169,110,0.1);color:var(--gold);padding:0.2rem 0.7rem;border-radius:2rem;vertical-align:middle;margin-left:0.5rem;">Today</span>
            @endif
        </h2>
    </div>
    <form method="GET" action="{{ route('admin.schedule') }}" class="date-picker-wrap">
        <input type="date" name="date" value="{{ $date }}">
        <button type="submit" class="btn-sm-gold"><i class="fas fa-search"></i> View</button>
    </form>
</div>

<div class="schedule-grid">
    @foreach($schedule as $barber => $data)
    <div class="barber-col">
        <div class="barber-col-header">
            <div class="barber-avatar">{{ strtoupper(substr($barber,0,1)) }}</div>
            <div>
                <strong>{{ $barber }}</strong>
                <span>{{ $barber === 'Dawam' ? 'Fade Specialist' : 'Style Specialist' }}</span>
            </div>
            <div class="barber-stats">
                <span class="booked-count">{{ $data['booked_count'] }}</span>
                <span class="avail-count"> / {{ $data['total_slots'] }} slots booked</span>
            </div>
        </div>

        <div class="slot-list">
            @foreach($data['slots'] as $slot)
            <div class="slot-item {{ $slot['booking'] ? 'booked' : 'available' }}">
                <span class="slot-time">{{ $slot['time'] }}</span>

                @if($slot['booking'])
                    <div class="slot-customer">
                        <strong>{{ $slot['booking']->name }}</strong>
                        <span>{{ $slot['booking']->service }}</span>
                    </div>
                    <span class="slot-badge badge-{{ $slot['booking']->payment_status }}">
                        {{ ucfirst($slot['booking']->payment_status) }}
                    </span>
                    <a href="{{ route('admin.bookings.show', $slot['booking']) }}" class="view-link">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                @else
                    <span class="slot-available-label">Available</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

@endsection