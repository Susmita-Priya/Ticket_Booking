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
        Schema::create('ticket_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('trip_id');
            $table->integer('vehicle_id');
            $table->json('seat_data');
            $table->string('passenger_name')->nullable();
            $table->string('passenger_phone');
            // $table->string('payment_method');
            // $table->string('total_payment');
            $table->date('travel_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_bookings');
    }
};
