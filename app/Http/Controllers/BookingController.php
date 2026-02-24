<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class BookingController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    // ─── Show landing page ────────────────────────────────────────────
    public function index()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'phone'      => 'required|string|max:20',
            'barber'     => 'required|in:Dawam,Cipta',
            'services'   => 'required|array|min:1',
            'services.*' => 'required|in:Haircut,Beard Trim,Hair Wash,Hair Color,Perming',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required|in:09:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00,18:00',
            'notes'      => 'nullable|string|max:500',
        ]);

        $prices = [
            'Haircut'    => 50000,
            'Beard Trim' => 50000,
            'Hair Wash'  => 25000,
            'Hair Color' => 200000,
            'Perming'    => 200000,
        ];

        $totalPrice   = collect($data['services'])->sum(fn($s) => $prices[$s] ?? 0);
        $serviceLabel = implode(', ', $data['services']);
        $orderId      = 'INVICTO-' . strtoupper(uniqid());

        $booking = Booking::create([
            'order_id'         => $orderId,
            'name'             => $data['name'],
            'phone'            => $data['phone'],
            'barber'           => $data['barber'],
            'service'          => $serviceLabel,
            'services'         => $data['services'],
            'appointment_date' => $data['date'],
            'appointment_time' => $data['time'],
            'notes'            => $data['notes'] ?? null,
            'amount'           => $totalPrice,
            'payment_status'   => 'pending',
        ]);

        $itemDetails = collect($data['services'])->map(fn($s) => [
            'id'       => $s,
            'price'    => $prices[$s],
            'quantity' => 1,
            'name'     => $s . ' - ' . $data['barber'],
        ])->values()->toArray();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $data['name'],
                'phone'      => $data['phone'],
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $booking->update(['snap_token' => $snapToken]);
            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Payment gateway error: ' . $e->getMessage()
            ], 500);
        }
    }

    // ─── Midtrans webhook ─────────────────────────────────────────────
    public function notification(Request $request)
    {
        try {
            $notif = new Notification();

            $orderId           = $notif->order_id;
            $transactionStatus = $notif->transaction_status;
            $fraudStatus       = $notif->fraud_status;
            $paymentType       = $notif->payment_type;

            $booking = Booking::where('order_id', $orderId)->firstOrFail();

            if ($transactionStatus === 'capture') {
                $status = $fraudStatus === 'accept' ? 'paid' : 'fraud';
            } elseif ($transactionStatus === 'settlement') {
                $status = 'paid';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $status = 'cancelled';
            } else {
                $status = 'pending';
            }

            $booking->update([
                'payment_status' => $status,
                'payment_type'   => $paymentType,
                'paid_at'        => $status === 'paid' ? now() : null,
            ]);

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // ─── Halaman hasil pembayaran ─────────────────────────────────────
    public function finish(Request $request)
    {
        $booking = Booking::where('order_id', $request->order_id)->first();

        if ($booking && $booking->payment_status === 'pending') {
            try {
                $status = \Midtrans\Transaction::status($request->order_id);
                $transactionStatus = $status->transaction_status;
                $fraudStatus       = $status->fraud_status ?? 'accept';

                if ($transactionStatus === 'capture') {
                    $paymentStatus = $fraudStatus === 'accept' ? 'paid' : 'fraud';
                } elseif ($transactionStatus === 'settlement') {
                    $paymentStatus = 'paid';
                } else {
                    $paymentStatus = $transactionStatus;
                }

                $booking->update([
                    'payment_status' => $paymentStatus,
                    'payment_type'   => $status->payment_type ?? null,
                    'paid_at'        => $paymentStatus === 'paid' ? now() : null,
                ]);
            } catch (\Exception $e) {
                $booking->update([
                    'payment_status' => 'paid',
                    'paid_at'        => now(),
                ]);
            }
            $booking->refresh();
        }
        return view('booking.finish', compact('booking'));
    }

    public function pending(Request $request)
    {
        $booking = Booking::where('order_id', $request->order_id)->first();

        if ($booking && $booking->payment_status === 'pending') {
            try {
                $status = \Midtrans\Transaction::status($request->order_id);
                $booking->update([
                    'payment_status' => 'pending',
                    'payment_type'   => $status->payment_type ?? null,
                ]);
            } catch (\Exception $e) {
                $booking->update(['payment_status' => 'pending']);
            }

            $booking->refresh();
        }

        return view('booking.pending', compact('booking'));
    }

    public function error(Request $request)
    {
        $booking = Booking::where('order_id', $request->order_id)->first();

        if ($booking && in_array($booking->payment_status, ['pending'])) {
            try {
                $status = \Midtrans\Transaction::status($request->order_id);
                $transactionStatus = $status->transaction_status;
                if (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
                    $booking->update([
                        'payment_status' => 'cancelled',
                        'payment_type'   => $status->payment_type ?? null,
                    ]);
                }
            } catch (\Exception $e) {
                $booking->update(['payment_status' => 'cancelled']);
            }

            $booking->refresh();
        }

        return view('booking.error', compact('booking'));
    }

    // ─── Admin: daftar semua booking ─────────────────────────────────
    public function adminIndex()
    {
        $bookings = Booking::latest()->paginate(20);
        return view('admin.bookings', compact('bookings'));
    }
}
