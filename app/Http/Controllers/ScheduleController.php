<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Semua slot jam yang tersedia
    const TIME_SLOTS = [
        '09:00', '10:00', '11:00', '12:00', '13:00',
        '14:00', '15:00', '16:00', '17:00', '18:00',
    ];

    const BARBERS = ['Dawam', 'Cipta'];

    /**
     * GET /schedule/check?date=2026-02-23&barber=Dawam
     *
     * Return slot yang sudah DIPESAN (booked) per barber pada tanggal tersebut.
     * Frontend akan tahu mana yang available (tidak ada di list ini).
     *
     * Response:
     * {
     *   "Dawam": ["09:00", "11:00"],
     *   "Cipta": ["10:00"]
     * }
     */
    public function check(Request $request)
    {
        $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'barber' => 'nullable|in:Dawam,Cipta',
        ]);

        $date   = $request->date;
        $barber = $request->barber; // null = semua barber

        $barbers = $barber ? [$barber] : self::BARBERS;

        $result = [];

        foreach ($barbers as $b) {
            // Ambil slot yang sudah dipesan dan paid/pending (jangan tampilkan yg cancelled)
            $bookedSlots = Booking::where('barber', $b)
                ->whereDate('appointment_date', $date)
                ->whereIn('payment_status', ['paid', 'pending'])
                ->pluck('appointment_time')
                ->map(fn($t) => substr($t, 0, 5)) // pastikan format HH:MM
                ->values()
                ->toArray();

            $result[$b] = $bookedSlots;
        }

        return response()->json($result);
    }

    /**
     * GET /schedule/available?date=2026-02-23&barber=Dawam
     *
     * Return slot yang TERSEDIA (kebalikan dari check).
     * Berguna jika ingin menampilkan hanya yang bisa dipilih.
     *
     * Response:
     * {
     *   "Dawam": ["10:00", "12:00", "13:00", ...],
     *   "Cipta": ["09:00", "11:00", ...]
     * }
     */
    public function available(Request $request)
    {
        $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'barber' => 'nullable|in:Dawam,Cipta',
        ]);

        $date   = $request->date;
        $barber = $request->barber;
        $barbers = $barber ? [$barber] : self::BARBERS;

        $result = [];

        foreach ($barbers as $b) {
            $bookedSlots = Booking::where('barber', $b)
                ->whereDate('appointment_date', $date)
                ->whereIn('payment_status', ['paid', 'pending'])
                ->pluck('appointment_time')
                ->map(fn($t) => substr($t, 0, 5))
                ->toArray();

            // Available = semua slot dikurangi yang sudah dipesan
            $result[$b] = array_values(
                array_diff(self::TIME_SLOTS, $bookedSlots)
            );
        }

        return response()->json($result);
    }
}