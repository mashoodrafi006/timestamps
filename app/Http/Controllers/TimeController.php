<?php

namespace App\Http\Controllers;

use App\Services\TimeService;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    private TimeService $timeService;

    public function __construct(TimeService $timeService)
    {
        $this->timeService = $timeService;
    }

    public function getDurationDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $inputParameters = $this->buildParameters($request);
        $details = $this->timeService->getTimeBreakDownDuration($inputParameters);

        return new \Illuminate\Http\JsonResponse(
            ['message' => 'Difference in times breakdown',
                'data' => $details
            ]);
    }

    public function searchBreakdownsByTimestamps(Request $request): \Illuminate\Http\JsonResponse
    {
        $startTimestamp = $request->input('first_timestamp');
        $endTimestamp = $request->input('second_timestamp');

        $timeBreakdownHistory = $this->timeService->searchBreakdownsByTimestamps($startTimestamp, $endTimestamp);
        return new \Illuminate\Http\JsonResponse(
            ['message' => 'Time breakdown history',
                'data' => $timeBreakdownHistory
            ]);
    }

    public function buildParameters(Request $request)
    {
        return [
            'first_timestamp' => $request->input('first_timestamp'),
            'second_timestamp' => $request->input('second_timestamp'),
            'expressions' => $request->input('expressions')
        ];
    }
}
