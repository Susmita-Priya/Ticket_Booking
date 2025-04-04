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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('owner_id');
            $table->foreignId('type_id');
            $table->string('category');
            $table->string('name');
            $table->string('vehicle_no');
            $table->string('engin_no');
            $table->string('chest_no');
            $table->integer('total_seat'); 
            $table->json('amenities_id');
            $table->string('document')->nullable();
            $table->string('is_booked')->default(0);
            $table->string('current_location_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
