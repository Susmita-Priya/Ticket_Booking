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
        Schema::table('ticket_bookings', function (Blueprint $table) {
            $table->string('user_id')->after('travel_date')->nullable();
            $table->string('type')->after('user_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_bookings', function (Blueprint $table) {
            //
        });
    }
};
