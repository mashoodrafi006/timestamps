<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class TimeController extends Controller {

    public function calculateTimeDifferenceDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $inputs = [
            'first_timestamp' => $request->input('first_timestamp'),
            'second_timestamp' => $request->input('second_timestamp'),
            'expressions' => $request->input('expressions')
        ];
        return new \Illuminate\Http\JsonResponse(['message' => 'API that takes timestamps with expressions']);
    }
}
