<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    const TIME_SLOTS = [
        '09:00', '10:00', '11:00', '12:00', '13:00',
        '14:00', '15:00', '16:00', '17:00', '18:00',
    ];

    const BARBERS = ['Dawam', 'Cipta'];

    public function index(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');

        // Ambil semua booking pada tanggal tersebut
        $bookings = Booking::whereDate('appointment_date', $date)
            ->whereIn('payment_status', ['paid', 'pending'])
            ->orderBy('appointment_time')
            ->get()
            ->groupBy('barber'); // grouped by barber name

        $schedule = [];

        foreach (self::BARBERS as $barber) {
            $barberBookings = $bookings->get($barber, collect());
            $slots = [];
            $bookedCount = 0;

            foreach (self::TIME_SLOTS as $time) {
                // Cari booking yang cocok dengan slot ini
                $booking = $barberBookings->first(function ($b) use ($time) {
                    return substr($b->appointment_time, 0, 5) === $time;
                });

                $slots[] = [
                    'time'    => $time,
                    'booking' => $booking ?? null,
                ];

                if ($booking) $bookedCount++;
            }

            $schedule[$barber] = [
                'slots'        => $slots,
                'booked_count' => $bookedCount,
                'total_slots'  => count(self::TIME_SLOTS),
            ];
        }

        return view('admin.schedule', compact('schedule', 'date'));
    }
}