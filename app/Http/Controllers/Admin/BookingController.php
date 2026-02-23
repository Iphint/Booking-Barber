<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // ─── List semua booking dengan filter & pagination ────────────────
    public function index(Request $request)
    {
        $query = Booking::latest();

        // Filter by status
        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        // Filter by barber
        if ($request->barber) {
            $query->where('barber', $request->barber);
        }

        // Filter by date
        if ($request->date) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Search by name, phone, or order_id
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('order_id', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        // Count per status untuk tabs
        $counts = [
            'all'       => Booking::count(),
            'paid'      => Booking::paid()->count(),
            'pending'   => Booking::pending()->count(),
            'cancelled' => Booking::cancelled()->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts'));
    }

    // ─── Detail satu booking ──────────────────────────────────────────
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    // ─── Update status booking ────────────────────────────────────────
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,cancelled,fraud',
        ]);

        $oldStatus = $booking->payment_status;
        $newStatus = $request->payment_status;

        $booking->update([
            'payment_status' => $newStatus,
            'paid_at' => $newStatus === 'paid' && $oldStatus !== 'paid' ? now() : $booking->paid_at,
        ]);

        return back()->with('success', "Booking #{$booking->order_id} status updated to {$newStatus}.");
    }

    // ─── Hapus booking ────────────────────────────────────────────────
    public function destroy(Booking $booking)
    {
        $orderId = $booking->order_id;
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', "Booking #{$orderId} has been deleted.");
    }
}