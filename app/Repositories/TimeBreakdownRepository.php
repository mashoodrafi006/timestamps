<?php

namespace App\Repositories;

use App\Models\TimeBreakdown;

class TimeBreakdownRepository
{
    function model()
    {
        return TimeBreakdown::class;
    }

    function save(TimeBreakdown $timeBreakdown) {
        $timeBreakdown->save();
    }
}
