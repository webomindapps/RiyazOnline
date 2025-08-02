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
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email');
            $table->string('phone');
            $table->string('phone_2')->nullable();
            $table->date('dob')->nullable();
            $table->string('age');
            $table->integer('gender')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('city')->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('emg_contact_no')->nullable();
            $table->string('emg_contact_person')->nullable();
            $table->string('emg_relation')->nullable();
            $table->string('student_whatsapp_no')->nullable();
            $table->date('date')->nullable();
            $table->date('date_joining')->nullable();
            $table->integer('penalty_amount')->nullable();
            $table->text('levels')->nullable();
            $table->date('date_changed')->nullable();
            $table->date('attrition_date')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('reg_status')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->text('gst_no')->nullable();
            $table->integer('payment_type')->default(0);
            $table->text('latest_paid_date')->nullable();
            $table->date('reminder_date')->nullable();
            $table->text('reminder')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
