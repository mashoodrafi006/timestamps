<?php

namespace App\Services;

const ONE_SECOND = 1;
const SECONDS_IN_MINUTE = 60;
const SECONDS_IN_HOUR = 3600;
const SECONDS_IN_DAY = 86400;
const SECONDS_IN_MONTH = 2592000;

class TimeService
{

    public function getTimeBreakDownDuration(array $data): array
    {
        $response = [];
        $timeExpressions = $data["expressions"];
        $sortedTimeFormats = sortTimeFormats($timeExpressions);
        $totalSeconds = getDurationsInSeconds($data["first_timestamp"], $data["second_timestamp"]);
        $unitValidityStatus = initializeValidTimeFormatsListed();
        foreach ($sortedTimeFormats as $timeWithUnit) {
            [$time, $unit] = $this->extractTimeAndUnit($timeWithUnit);
            if ($unitValidityStatus[$unit]) {
                return [
                    'message' => 'The time expression already have the format defined',
                    'body' => $unit
                ];
            }
            $secondsPerUnit = $this->getSecondsForUnit($unit);
            if (isLastExpression($sortedTimeFormats, $timeWithUnit)) {
                if ($secondsPerUnit > 0) {
                    $lastValue = number_format($totalSeconds / ($secondsPerUnit * $time), 2);
                    $response[$time . $unit] = $lastValue;
                }
            } else {
                if (($totalSeconds / ($secondsPerUnit * $time)) >= 1) {
                    $totalTime = $totalSeconds / ($secondsPerUnit * $time);
                    $totalTimeInUnits = number_format(intval($totalTime), 2);
                    $totalSeconds = ($totalTime - $totalTimeInUnits) * $secondsPerUnit * $time;
                    $response[$time . $unit] = $totalTimeInUnits;
                    $unitValidityStatus[$unit] = true;
                } else {
                    $response[$time . $unit] = 0;
                }
            }
        }

        return $response;
    }

    function extractTimeAndUnit($timeWithUnit)
    {
        preg_match('/^(\d+)([a-zA-Z]+)$/', $timeWithUnit, $match);
        return [$match[1], $match[2]];
    }

    function getSecondsForUnit($unit)
    {
        $seconds = 0;
        switch ($unit) {
            case "m":
                $seconds = SECONDS_IN_MONTH;
                break;
            case "d":
                $seconds = SECONDS_IN_DAY;
                break;
            case "h":
                $seconds = SECONDS_IN_HOUR;
                break;
            case "i":
                $seconds = SECONDS_IN_MINUTE;
                break;
            case "s":
                $seconds = ONE_SECOND;
                break;
            default:
                break;
        }
        return $seconds;
    }
}

function isLastExpression(array $sortedTimeFormats, $timeWithUnit)
{
    return end($sortedTimeFormats) === $timeWithUnit;
}

function initializeValidTimeFormatsListed()
{
    return [
        'm' => false,
        'd' => false,
        'h' => false,
        'i' => false,
        's' => false,
    ];
}

function getDurationsInSeconds($firstTimestamp, $secondTimestamp)
{
    return strtotime($secondTimestamp) - strtotime($firstTimestamp);
}

function sortTimeFormats(array $listTimeExpressions): array
{
    $timeFormats = ['m', 'd', 'h', 'i', 's'];
    $result = [];

    // Initialize the result arrays
    foreach ($timeFormats as $unit) {
        $result[$unit] = [];
    }

    // Loop through the timeStrings
    foreach ($listTimeExpressions as $timeFormat) {
        // Extract the unit (m, d, h, i, s) and the value
        preg_match('/^(\d+)([a-zA-Z]+)$/', $timeFormat, $matches);
        $timeValue = $matches[1];
        $unit = $matches[2];

        // Handle cases where the value is zero or not provided
        $timeValue = ($timeValue !== '') ? intval($timeValue) : 1;

        // Add the timeString to the appropriate unit array
        $result[$unit][] = $timeValue . $unit;
    }

    // Sort each unit array in descending order
    foreach ($timeFormats as $unit) {
        usort($result[$unit], function ($a, $b) {
            $aValue = intval($a);
            $bValue = intval($b);

            return $bValue - $aValue;
        });
    }

    // Merge the sorted arrays and return the result
    return array_merge($result['m'], $result['d'], $result['h'], $result['i'], $result['s']);
}
