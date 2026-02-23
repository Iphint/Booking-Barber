@extends('admin.layouts.app')
@section('title', 'Bookings')
@section('page-title', 'Bookings')

@push('styles')
<style>
    .filter-bar {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .filter-bar input,
    .filter-bar select {
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        color: var(--white);
        padding: 0.6rem 1rem;
        font-family: var(--font-body);
        font-size: 0.85rem;
        outline: none;
        transition: var(--transition);
        appearance: none;
        -webkit-appearance: none;
    }
    .filter-bar input:focus,
    .filter-bar select:focus { border-color: var(--gold); }
    .filter-bar input { flex: 1; min-width: 200px; }
    .btn-sm-gold {
        background: var(--gold);
        color: var(--black);
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: var(--radius);
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        font-family: var(--font-body);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: var(--transition);
    }
    .btn-sm-gold:hover { background: var(--gold-light); }
    .btn-sm-ghost {
        background: transparent;
        color: var(--muted);
        border: 1px solid var(--border);
        padding: 0.6rem 1.2rem;
        border-radius: var(--radius);
        font-size: 0.8rem;
        cursor: pointer;
        font-family: var(--font-body);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: var(--transition);
    }
    .btn-sm-ghost:hover { border-color: var(--gold); color: var(--gold); }

    .table-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { border-bottom: 1px solid var(--border); }
    th {
        text-align: left;
        font-size: 0.68rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 1rem 1.2rem;
        font-weight: 500;
        white-space: nowrap;
    }
    td {
        padding: 1rem 1.2rem;
        font-size: 0.85rem;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        vertical-align: middle;
        white-space: nowrap;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: rgba(255,255,255,0.02); }

    .badge-status {
        display: inline-block;
        padding: 0.25rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 500;
    }
    .badge-paid      { background: rgba(80,200,120,0.12);  color: var(--success); }
    .badge-pending   { background: rgba(234,179,8,0.12);   color: var(--warning); }
    .badge-cancelled { background: rgba(255,107,107,0.12); color: var(--danger); }
    .badge-fraud     { background: rgba(255,107,107,0.12); color: var(--danger); }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.35rem 0.8rem;
        border-radius: var(--radius);
        font-size: 0.75rem;
        text-decoration: none;
        transition: var(--transition);
        border: 1px solid transparent;
    }
    .action-view { background: rgba(201,169,110,0.1); color: var(--gold); border-color: rgba(201,169,110,0.2); }
    .action-view:hover { background: var(--gold); color: var(--black); }
    .action-delete { background: rgba(255,107,107,0.08); color: var(--danger); border-color: rgba(255,107,107,0.2); }
    .action-delete:hover { background: var(--danger); color: var(--white); }

    .table-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .table-info { font-size: 0.78rem; color: var(--muted); }
    .pagination { display: flex; gap: 0.4rem; }
    .pagination a, .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px; height: 32px;
        border-radius: var(--radius);
        font-size: 0.8rem;
        text-decoration: none;
        transition: var(--transition);
        border: 1px solid var(--border);
        color: var(--muted);
    }
    .pagination a:hover { border-color: var(--gold); color: var(--gold); }
    .pagination span.active { background: var(--gold); color: var(--black); border-color: var(--gold); font-weight: 700; }
    .pagination span.disabled { opacity: 0.3; cursor: not-allowed; }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--muted);
    }
    .empty-state i { font-size: 2.5rem; color: rgba(201,169,110,0.2); display: block; margin-bottom: 1rem; }
    .empty-state h3 { font-size: 1rem; color: var(--white); margin-bottom: 0.4rem; }

    .status-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .status-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1.1rem;
        border-radius: 2rem;
        font-size: 0.78rem;
        text-decoration: none;
        border: 1px solid var(--border);
        color: var(--muted);
        transition: var(--transition);
    }
    .status-tab:hover { border-color: var(--gold); color: var(--gold); }
    .status-tab.active { background: var(--gold); color: var(--black); border-color: var(--gold); font-weight: 500; }
    .status-tab .count {
        background: rgba(0,0,0,0.2);
        padding: 0.1rem 0.4rem;
        border-radius: 1rem;
        font-size: 0.65rem;
    }
    .status-tab.active .count { background: rgba(0,0,0,0.25); }
</style>
@endpush

@section('content')

{{-- Status Tabs --}}
<div class="status-tabs">
    <a href="{{ route('admin.bookings.index') }}" class="status-tab {{ !request('status') ? 'active' : '' }}">
        <i class="fas fa-th-list"></i> All <span class="count">{{ $counts['all'] }}</span>
    </a>
    <a href="{{ route('admin.bookings.index', ['status' => 'paid']) }}" class="status-tab {{ request('status') === 'paid' ? 'active' : '' }}">
        <i class="fas fa-check-circle"></i> Paid <span class="count">{{ $counts['paid'] }}</span>
    </a>
    <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="status-tab {{ request('status') === 'pending' ? 'active' : '' }}">
        <i class="fas fa-clock"></i> Pending <span class="count">{{ $counts['pending'] }}</span>
    </a>
    <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="status-tab {{ request('status') === 'cancelled' ? 'active' : '' }}">
        <i class="fas fa-times-circle"></i> Cancelled <span class="count">{{ $counts['cancelled'] }}</span>
    </a>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.bookings.index') }}">
    <input type="hidden" name="status" value="{{ request('status') }}">
    <div class="filter-bar">
        <input type="text" name="search" placeholder="🔍 Search name, phone, order ID..." value="{{ request('search') }}">
        <select name="barber">
            <option value="">All Barbers</option>
            <option value="Dawam"  {{ request('barber') === 'Dawam'  ? 'selected' : '' }}>Dawam</option>
            <option value="Cipta"  {{ request('barber') === 'Cipta'  ? 'selected' : '' }}>Cipta</option>
        </select>
        <input type="date" name="date" value="{{ request('date') }}">
        <button type="submit" class="btn-sm-gold"><i class="fas fa-filter"></i> Filter</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn-sm-ghost"><i class="fas fa-times"></i> Reset</a>
    </div>
</form>

{{-- Table --}}
<div class="table-card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Barber</th>
                    <th>Date & Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td style="color:var(--muted);font-size:0.75rem;">{{ $b->id }}</td>
                    <td>
                        <span style="color:var(--white);font-weight:500;">{{ $b->name }}</span>
                        <span style="display:block;font-size:0.72rem;color:var(--muted);">{{ $b->phone }}</span>
                    </td>
                    <td style="color:var(--muted);">{{ $b->service }}</td>
                    <td>
                        <span style="background:rgba(201,169,110,0.1);color:var(--gold);padding:0.2rem 0.6rem;border-radius:2rem;font-size:0.72rem;">
                            {{ $b->barber }}
                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:0.82rem;">
                        {{ $b->formatted_date }}<br>
                        <span style="color:var(--gold);">{{ substr($b->appointment_time,0,5) }}</span>
                    </td>
                    <td style="color:var(--gold);font-family:var(--font-display);">{{ $b->formatted_amount }}</td>
                    <td>
                        <span class="badge-status badge-{{ $b->payment_status }}">
                            {{ ucfirst($b->payment_status) }}
                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:0.78rem;">{{ $b->payment_type ?? '–' }}</td>
                    <td>
                        <div style="display:flex;gap:0.4rem;">
                            <a href="{{ route('admin.bookings.show', $b) }}" class="action-btn action-view">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $b) }}"
                                  onsubmit="return confirm('Delete this booking?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" style="border:none;cursor:pointer;font-family:var(--font-body);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h3>No bookings found</h3>
                            <p>Try adjusting your filters.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span class="table-info">
            Showing {{ $bookings->firstItem() ?? 0 }}–{{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} bookings
        </span>
        <div class="pagination">
            @if($bookings->onFirstPage())
                <span class="disabled"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $bookings->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
            @endif

            @foreach($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                @if($page == $bookings->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($bookings->hasMorePages())
                <a href="{{ $bookings->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="disabled"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
</div>

@endsection