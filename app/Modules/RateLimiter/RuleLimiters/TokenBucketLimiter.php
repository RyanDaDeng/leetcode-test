<?php

namespace App\Modules\RateLimiter\RuleLimiters;


use Carbon\Carbon;

class TokenBucketLimiter
{
    private $lastReqTime;

    // config
    private $rate; // 1 token per second
    private $capacity;

    // state
    private $currentTokens;


    public function __construct($rate = 1, $capacity = 100)
    {
        $this->lastReqTime = Carbon::now();
        $this->rate = $rate;
        $this->capacity = $capacity;
        $this->currentTokens = $capacity;
    }

    public function allowRequest(
        Carbon $requestTime,
        int $consumedTokens = 1
    ): bool
    {
        // refill the bucket
        $tokensToBeRefilled = $requestTime->diffInRealSeconds($this->lastReqTime) * $this->rate;
        $this->currentTokens = min($this->capacity, $tokensToBeRefilled + $this->currentTokens);

        if ($this->currentTokens >= $consumedTokens) {
            $this->currentTokens -= $consumedTokens;
            $this->lastReqTime = Carbon::now();
            return true;
        }

        return false;
    }


    /**
     * @param int $currentTokens
     * @return TokenBucketLimiter
     */
    public function setCurrentTokens(int $currentTokens): TokenBucketLimiter
    {
        $this->currentTokens = $currentTokens;
        return $this;
    }

    /**
     * @param Carbon $lastReqTime
     * @return TokenBucketLimiter
     */
    public function setLastReqTime(Carbon $lastReqTime): TokenBucketLimiter
    {
        $this->lastReqTime = $lastReqTime;
        return $this;
    }


    public function getCurrentTokens(): int
    {
        return $this->currentTokens;
    }
}
