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
        Schema::create('vehicle_publisheds', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->integer('start_location_id')->nullable();
            $table->integer('end_location_id')->nullable();
            $table->date('journey_date')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_publisheds');
    }
};
