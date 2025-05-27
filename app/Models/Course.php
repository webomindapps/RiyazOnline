<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'description',
        'new_student_fees',
        'old_student_fees',
        'priority',
        'status',
    ];
}
