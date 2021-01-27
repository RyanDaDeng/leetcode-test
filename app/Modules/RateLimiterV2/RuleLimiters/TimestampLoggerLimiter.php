<?php

namespace App\Modules\RateLimiterV2\RuleLimiters;


use Carbon\Carbon;

class TimestampLoggerLimiter
{
    // config data
    private $interval;
    private $limit = 100;

    // client data
    private $timestampMap = [];

    public function __construct(
        $limit = 100, $interval = 60000
    )
    {
        $this->limit = $limit;
        $this->interval = $interval;
    }


    public function allowRequest(Carbon $requestTime): bool
    {
        // we need to cleanup our logger
        $timestamp = $requestTime->getTimestamp();
        $this->cleanup($timestamp);

        // we calculate total counters within interval
        $totalCounter = $this->getCounter();

        if ($totalCounter < $this->limit) {
            $this->hit($timestamp);
            return true;
        }

        return false;
    }


    public function hit($timestamp)
    {
        if (!isset($this->timestampMap[$timestamp])) {
            $this->timestampMap[$timestamp] = 1;
        } else {
            $this->timestampMap[$timestamp]++;
        }
    }


    private function cleanup($timestamp)
    {
        $start = Carbon::parse($timestamp)->subMilliseconds($this->interval)->getTimestamp();
        foreach ($this->timestampMap as $timestampValue => $counter) {
            if ($timestampValue < $start) {
                unset($this->timestampMap[$timestampValue]);
            }
        }
    }

    public function setTimestampMap($timestamps = []): self
    {
        $this->timestampMap = $timestamps;
        return $this;
    }


    public function getCounter(): int
    {
        return array_sum(array_values($this->timestampMap));
    }

}
