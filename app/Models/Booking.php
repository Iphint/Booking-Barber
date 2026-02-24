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
        'services',
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
        'services'         => 'array',
    ];

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

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::STATUS_PAID);
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', self::STATUS_PENDING);
    }

    public function scopeCancelled($query)
    {
        return $query->where('payment_status', self::STATUS_CANCELLED);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today());
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    public function scopeByBarber($query, string $barber)
    {
        return $query->where('barber', $barber);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }


    public function getFormattedDateAttribute(): string
    {
        return $this->appointment_date->format('d M Y');
    }

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

    public function getIsPaidAttribute(): bool
    {
        return $this->payment_status === self::STATUS_PAID;
    }

    // $booking->is_pending → true / false
    public function getIsPendingAttribute(): bool
    {
        return $this->payment_status === self::STATUS_PENDING;
    }

    public static function getPrice(string $service): int
    {
        return self::SERVICES[$service] ?? 0;
    }

    public static function generateOrderId(): string
    {
        return 'INVICTO-' . strtoupper(uniqid());
    }
}