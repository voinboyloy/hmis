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
        Schema::table('encounters', function (Blueprint $table) {
            $table->foreignId('icd_code_id')->nullable()->constrained()->after('notes');
            $table->dropColumn('diagnosis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encounters', function (Blueprint $table) {
            $table->dropForeign(['icd_code_id']);
            $table->dropColumn('icd_code_id');
            $table->string('diagnosis')->nullable();
        });
    }
};
