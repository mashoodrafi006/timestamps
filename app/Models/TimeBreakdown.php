<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeBreakdown extends Model
{
    protected $table = 'time_breakdown';

    protected $fillable = [
        'first_timestamp',
        'second_timestamp',
        'expressions',
        'time_breakdown'
    ];

    protected $casts = [
        'expressions' => 'json',
        'time_breakdown' => 'json'
    ];
}
