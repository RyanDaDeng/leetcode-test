<?php


namespace App\Modules\RateLimiter\RuleLimiters;


use Carbon\Carbon;

class CounterLimiter
{
    // @TODO client-related data could be stored in Cache store
    private $lastReqTime;
    private $reqCounter;

    // config
    public $limit;
    public $interval; //ms

    public function __construct($limit = 100, $interval = 60000)
    {
        $this->lastReqTime = Carbon::now();
        $this->limit = $limit;
        $this->interval = $interval;
    }

    public function allowRequest(Carbon $requestTime): bool
    {
        if ($this->lastReqTime->addMilliseconds($this->interval)->greaterThan($requestTime)) {
            $this->reqCounter++;
            return $this->reqCounter <= $this->limit;
        } else {
            $this->lastReqTime = Carbon::now();
            $this->reqCounter = 1;
            return true;
        }
    }

    /**
     * @param Carbon $lastReqTime
     * @return CounterLimiter
     */
    public function setLastReqTime(Carbon $lastReqTime): CounterLimiter
    {
        $this->lastReqTime = $lastReqTime;
        return $this;
    }

    /**
     * @param int $reqCounter
     * @return CounterLimiter
     */
    public function setReqCounter(int $reqCounter): CounterLimiter
    {
        $this->reqCounter = $reqCounter;
        return $this;
    }
}
