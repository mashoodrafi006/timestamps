<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TimeBreakdownHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = $this->validateTimeInput($this->buildParameters($request));

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $next($request);
    }

    public function buildParameters(Request $request)
    {
        return [
            'first_timestamp' => $request->input('first_timestamp'),
            'second_timestamp' => $request->input('second_timestamp'),
            'expressions' => $request->input('expressions')
        ];
    }

    public function validateTimeInput(array $data): \Illuminate\Validation\Validator
    {
        $rules = [
            'first_timestamp' => 'required|date_format:Y-m-d H:i:s',
            'second_timestamp' => 'required|date_format:Y-m-d H:i:s'
        ];
        return Validator::make($data, $rules);
    }
}
