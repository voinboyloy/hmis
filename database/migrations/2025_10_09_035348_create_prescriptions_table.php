<?php
// xxxx_xx_xx_xxxxxx_create_prescriptions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encounter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medication_id')->constrained()->cascadeOnDelete();
            $table->string('dosage'); // e.g., "1 tablet", "10ml"
            $table->string('frequency'); // e.g., "Twice a day", "Every 6 hours"
            $table->string('duration'); // e.g., "7 days", "Until finished"
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
