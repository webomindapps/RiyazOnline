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
        Schema::create('student_course_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->integer('teacher')->default(1);
            $table->unsignedBigInteger('course_id');
            $table->string('course_name');
            $table->string('invoice_no');
            $table->integer('type')->default(1);
            $table->integer('method');
            $table->float('convenience_fees');
            $table->float('grand_total');
            $table->float('amount');
            $table->date('due_date');
            $table->date('paid_date');
            $table->float('penalty_amount')->default(0);
            $table->integer('manual')->default(1);
            $table->float('gst_amount');
            $table->string('financial_year');
            $table->string('pdf_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course_details');
    }
};
