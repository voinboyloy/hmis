<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // ... in the migration file
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // You might want this to be nullable if not all users are patients,
        // and add a foreign key constraint if 'patients' table exists.
        $table->foreignId('patient_id')->nullable()->after('two_factor_confirmed_at')->constrained();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropConstrainedForeignId('patient_id');
    });
}
};
