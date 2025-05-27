<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMail extends Model
{
    protected $fillable = [
        'name',
        'email',
        'status',
    ];
}
