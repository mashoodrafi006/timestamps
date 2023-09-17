<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class ValidateRequests
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = $this->validateTimeInput($this->buildParameters($request));

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        return $next($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildParameters(Request $request)
    {
        return [
            'first_timestamp' => $request->input('first_timestamp'),
            'second_timestamp' => $request->input('second_timestamp'),
            'expressions' => $request->input('expressions')
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    public function validateTimeInput(array $data): \Illuminate\Validation\Validator
    {
        $rules = [
            'first_timestamp' => 'required|date_format:Y-m-d H:i:s',
            'second_timestamp' => 'required|date_format:Y-m-d H:i:s',
            'expressions.*' => ['distinct'],
            'expressions' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $item) {
                        if (!preg_match('/^(\d+)?[mdhis]$/', $item)) {
                            $fail("The $attribute array should have formats 'm', 'd', 'h', 'i', 's' || integers followed by 'm', 'd', 'h', 'i', 's'.");
                            break;
                        }
                    }
                },
            ],
        ];
        return Validator::make($data, $rules);
    }
}
