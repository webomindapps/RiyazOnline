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
        Schema::create('temp_students', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email');
            $table->string('age');
            $table->string('phone');
            $table->string('phone_two');
            $table->string('course');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('city')->nullable();
            $table->float('convenience_fees');
            $table->float('total_fees');
            $table->float('gst_amount');
            $table->float('grand_total');
            $table->tinyInteger('status');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_students');
    }
};
