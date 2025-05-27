<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourseDetail extends Model
{
    protected $fillable = [
        'student_id',
        'teacher',
        'course_id',
        'course_name',
        'invoice_no',
        'type',
        'method',
        'convenience_fees',
        'grand_total',
        'amount',
        'due_date',
        'paid_date',
        'penalty_amount',
        'manual',
        'gst_amount',
        'financial_year',
        'pdf_link',
    ];

    public function student()
    {
        return $this->belongsTo(StudentDetail::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
