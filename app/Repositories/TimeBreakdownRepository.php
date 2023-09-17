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

    function findByTimes(string $firstTimestamp, string $secondTimestamp) {
        return TimeBreakdown::where('first_timestamp', $firstTimestamp)
            ->where('second_timestamp', $secondTimestamp)
            ->first();
    }
}
