<?php

namespace App\Http\Controllers;
use App\Services\TimeService;
use Illuminate\Http\Request;

class TimeController extends Controller {

    private TimeService $timeService;

    public function __construct(TimeService $timeService)
    {
        $this->timeService = $timeService;
    }

    public function getDurationDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $details = $this->timeService->getTimeBreakDownDuration($this->buildParameters($request));

        return new \Illuminate\Http\JsonResponse(
            ['message' => 'API that takes timestamps with expressions',
             'data' => $details
            ]);
    }

    public function buildParameters(Request $request) {
        return [
            'first_timestamp' => $request->input('first_timestamp'),
            'second_timestamp' => $request->input('second_timestamp'),
            'expressions' => $request->input('expressions')
        ];
    }
}
