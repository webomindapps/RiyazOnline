<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempStudent extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'f_name',
        'l_name',
        'email',
        'phone',
        'phone_two',
        'age',
        'course',
        'country_id',
        'state_id',
        'city',
        'convenience_fees',
        'total_fees',
        'gst_amount',
        'grand_total',
        'status',
        'date',
    ];
}
