
Copy

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('name');
            $table->string('phone', 20);
            $table->string('barber');
            $table->string('service');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('notes')->nullable();
            $table->unsignedInteger('amount');
            $table->string('payment_status')->default('pending');
            $table->string('payment_type')->nullable();
            $table->text('snap_token')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['barber', 'appointment_date']);
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};