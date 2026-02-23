<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'   => Booking::count(),
            'paid'    => Booking::paid()->count(),
            'pending' => Booking::pending()->count(),
            'cancelled' => Booking::cancelled()->count(),
            'today'   => Booking::today()->count(),

            // Paid bulan ini
            'paid_month' => Booking::paid()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),

            // Total revenue
            'revenue' => Booking::paid()->sum('amount'),
            'revenue_month' => Booking::paid()
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
        ];

        // Format revenue
        $stats['revenue_formatted']       = 'Rp ' . number_format($stats['revenue'], 0, ',', '.');
        $stats['revenue_month_formatted'] = 'Rp ' . number_format($stats['revenue_month'], 0, ',', '.');

        // Recent bookings (10 terbaru)
        $recentBookings = Booking::latest()->take(10)->get();

        // Today's bookings sorted by time
        $todayBookings = Booking::today()
            ->whereIn('payment_status', ['paid', 'pending'])
            ->orderBy('appointment_time')
            ->get();

        // Revenue per barber bulan ini
        $revenueByBarber = Booking::paid()
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->select('barber', DB::raw('SUM(amount) as total'))
            ->groupBy('barber')
            ->pluck('total', 'barber');

        // Pastikan semua barber ada meskipun 0
        foreach (['Dawam', 'Cipta'] as $b) {
            if (!isset($revenueByBarber[$b])) {
                $revenueByBarber[$b] = 0;
            }
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentBookings',
            'todayBookings',
            'revenueByBarber'
        ));
    }
}