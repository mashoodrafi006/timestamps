<?php

namespace App\Repositories;

use App\Models\TimeBreakdown;

/**
 *
 */
class TimeBreakdownRepository
{
    /**
     * @return string
     */
    function model()
    {
        return TimeBreakdown::class;
    }

    /**
     * @param TimeBreakdown $timeBreakdown
     * @return void
     */
    function save(TimeBreakdown $timeBreakdown) {
        $timeBreakdown->save();
    }

    /**
     * @param string $firstTimestamp
     * @param string $secondTimestamp
     * @return mixed
     */
    function findByTimes(string $firstTimestamp, string $secondTimestamp) {
        return TimeBreakdown::where('first_timestamp', $firstTimestamp)
            ->where('second_timestamp', $secondTimestamp)
            ->first();
    }
}
