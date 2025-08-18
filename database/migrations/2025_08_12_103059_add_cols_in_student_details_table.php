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
        Schema::table('student_details', function (Blueprint $table) {
            $table->unsignedBigInteger('p_country_id')->nullable();
            $table->unsignedBigInteger('p_state_id')->nullable();
            $table->string('p_city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_details', function (Blueprint $table) {
            $table->dropColumn('p_country_id');
            $table->dropColumn('p_state_id');
            $table->dropColumn('p_city');
        });
    }
};
