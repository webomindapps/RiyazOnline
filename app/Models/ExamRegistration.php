<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRegistration extends Model
{
    protected $guarded = ['id'];
    public function student()
    {
        return $this->hasOne(StudentDetail::class, 'id', 'student_id');
    }
}
