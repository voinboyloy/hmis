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
        Schema::create('lab_orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
    $table->foreignId('encounter_id')->constrained()->cascadeOnDelete();
    $table->json('tests_ordered'); // Stores an array of LabTest IDs
    $table->string('status'); // e.g., Pending, Completed, Canceled
    $table->text('results_notes')->nullable();
    $table->string('results_file_path')->nullable(); // For storing the path to a PDF/image
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_orders');
    }
};
