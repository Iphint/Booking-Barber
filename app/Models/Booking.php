<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'phone',
        'barber',
        'service',
        'appointment_date',
        'appointment_time',
        'notes',
        'amount',
        'payment_status',
        'payment_type',
        'snap_token',
        'paid_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'paid_at'          => 'datetime',
        'amount'           => 'integer',
    ];

    // =============================================
    // CONSTANTS
    // =============================================
    const STATUS_PENDING   = 'pending';
    const STATUS_PAID      = 'paid';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_FRAUD     = 'fraud';

    const SERVICES = [
        'Haircut'    => 50000,
        'Beard Trim' => 50000,
        'Hair Wash'  => 25000,
        'Hair Color' => 200000,
        'Perming'    => 200000,
    ];

    const BARBERS = ['Dawam', 'Cipta'];

    // =============================================
    // SCOPES — untuk filter query dengan mudah
    // =============================================

    // Booking::paid()->get()
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::STATUS_PAID);
    }

    // Booking::pending()->get()
    public function scopePending($query)
    {
        return $query->where('payment_status', self::STATUS_PENDING);
    }

    // Booking::cancelled()->get()
    public function scopeCancelled($query)
    {
        return $query->where('payment_status', self::STATUS_CANCELLED);
    }

    // Booking::upcoming()->get() — appointment hari ini ke depan
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today());
    }

    // Booking::today()->get()
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    // Booking::byBarber('Dawam')->get()
    public function scopeByBarber($query, string $barber)
    {
        return $query->where('barber', $barber);
    }

    // =============================================
    // ACCESSORS — format data otomatis
    // =============================================

    // $booking->formatted_amount → "Rp 50.000"
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // $booking->formatted_date → "23 Feb 2026"
    public function getFormattedDateAttribute(): string
    {
        return $this->appointment_date->format('d M Y');
    }

    // $booking->status_badge → "✅ Paid"
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            self::STATUS_PAID      => '✅ Paid',
            self::STATUS_PENDING   => '⏳ Pending',
            self::STATUS_CANCELLED => '❌ Cancelled',
            self::STATUS_FRAUD     => '⚠️ Fraud',
            default                => ucfirst($this->payment_status),
        };
    }

    // $booking->is_paid → true / false
    public function getIsPaidAttribute(): bool
    {
        return $this->payment_status === self::STATUS_PAID;
    }

    // $booking->is_pending → true / false
    public function getIsPendingAttribute(): bool
    {
        return $this->payment_status === self::STATUS_PENDING;
    }

    // =============================================
    // STATIC HELPERS
    // =============================================

    // Ambil harga berdasarkan nama service
    // Booking::getPrice('Haircut') → 50000
    public static function getPrice(string $service): int
    {
        return self::SERVICES[$service] ?? 0;
    }

    // Generate order ID unik
    // Booking::generateOrderId() → "INVICTO-ABC123XY"
    public static function generateOrderId(): string
    {
        return 'INVICTO-' . strtoupper(uniqid());
    }
}