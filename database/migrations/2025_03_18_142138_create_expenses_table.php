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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->string('department');
            $table->string('type');
            $table->string('employee_id')->nullable();
            $table->string('counter_id')->nullable();
            $table->string('vehicle_id')->nullable();
            $table->string('route_id')->nullable();
            $table->decimal('amount');
            $table->date('date');
            $table->string('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
