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
        Schema::create('plane_journeys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('plane_id');
            $table->json('journey_types_id');
            $table->foreignId('from_country_id');
            $table->foreignId('to_country_id');
            $table->foreignId('start_location_id');
            $table->foreignId('end_location_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_seats');
            $table->integer('available_seats')->nullable();
            $table->string('published_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plane_journeys');
    }
};
