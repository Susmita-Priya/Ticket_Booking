<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seat_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('vehicle_id');
            $table->integer('seat_id');
            $table->string('seat_no');
            $table->string('booking_date');
            $table->string('payment_amount');
            $table->string('passenger_name')->nullable();
            $table->string('passenger_phone')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_bookings');
    }
};
