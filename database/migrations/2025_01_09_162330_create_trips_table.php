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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('route_id');
            $table->integer('vehicle_id');
            $table->integer('driver_id');
            $table->integer('supervisor_id');
            $table->integer('helper_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('total_route_cost');
            $table->string('ticket_price');
            $table->integer('trip_status')->default(0);
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
