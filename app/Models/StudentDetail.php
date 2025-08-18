<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    protected $fillable = [
        'guru',
        'country_id',
        'state_id',
        'city',
        'f_name',
        'l_name',
        'email',
        'phone',
        'phone_2',
        'dob',
        'age',
        'gender',
        'profile_picture',
        'father_name',
        'mother_name',
        'current_address',
        'p_country_id',
        'p_state_id',
        'p_city',
        'permanent_address',
        'emg_contact_no',
        'emg_contact_person',
        'emg_relation',
        'student_whatsapp_no',
        'date',
        'date_joining',
        'penalty_amount',
        'levels',
        'date_changed',
        'attrition_date',
        'comment',
        'reg_status',
        'status',
        'gst_no',
        'payment_type',
        'latest_paid_date',
        'reminder_date',
        'reminder',
    ];

    public function studentcourse()
    {
        return $this->hasOne(StudentCourseDetail::class, 'student_id', 'id')->latestOfMany();
    }
    public function studentcourses()
    {
        return $this->hasMany(StudentCourseDetail::class, 'student_id', 'id')->orderBy('paid_date', 'DESC')->orderBy('id', 'DESC');
    }
    public function course()
    {
        return $this->belongsToMany(Course::class, 'student_course_details', 'student_id', 'course_id', 'id', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function pcountry()
    {
        return $this->belongsTo(Country::class, 'p_country_id', 'id');
    }
    public function pstate()
    {
        return $this->belongsTo(State::class, 'p_state_id', 'id');
    }
    public function getNameAttribute()
    {
        return "{$this->f_name} {$this->l_name}";
    }
}
