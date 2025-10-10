<?php

// xxxx_xx_xx_xxxxxx_create_appointments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->comment('Doctor ID')->constrained()->cascadeOnDelete();
            $table->dateTime('schedule');
            $table->text('reason')->nullable();
            $table->string('status'); // e.g., Scheduled, Confirmed, Completed, Canceled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
