<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempStudent extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'name',
        'email',
        'phone',
        'phone_two',
        'age',
        'course',
        'country_id',
        'convenience_fees',
        'total_fees',
        'gst_amount',
        'grand_total',
        'status',
        'date',
    ];
}
