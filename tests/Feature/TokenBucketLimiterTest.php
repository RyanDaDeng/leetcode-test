<?php

namespace Tests\Feature;


use App\Modules\RateLimiter\RuleLimiters\TokenBucketLimiter;
use Carbon\Carbon;
use Tests\TestCase;

class TokenBucketLimiterTest extends TestCase
{

    public function testNoTokens()
    {

        $lastReqTime = Carbon::parse('2020-01-01 00:01:00');
        $currentTokens = 0;
        $reqTime = Carbon::parse('2020-01-01 00:01:01');
        $rate = 1 / 2;
        $capacity = 100;

        $limiter = new TokenBucketLimiter($rate, $capacity);
        $limiter->setCurrentTokens($currentTokens)->setLastReqTime($lastReqTime);

        $this->assertEquals(false, $limiter->allowRequest($reqTime, 1));
    }


    public function testNoEnoughTokens()
    {
        $lastReqTime = Carbon::parse('2020-01-01 00:01:00');
        $currentTokens = 1;
        $reqTime = Carbon::parse('2020-01-01 00:01:01');
        $rate = 1 / 2;
        $capacity = 100;

        $limiter = new TokenBucketLimiter($rate, $capacity);
        $limiter->setCurrentTokens($currentTokens)->setLastReqTime($lastReqTime);

        $this->assertEquals(false, $limiter->allowRequest($reqTime, 2));
    }


    public function testRefillTokens()
    {
        $lastReqTime = Carbon::parse('2020-01-01 00:01:00');
        $currentTokens = 1;
        $reqTime = Carbon::parse('2020-01-01 00:01:01');
        $rate = 1;
        $capacity = 100;

        $limiter = new TokenBucketLimiter($rate, $capacity);
        $limiter->setCurrentTokens($currentTokens)->setLastReqTime($lastReqTime);

        $this->assertEquals(true, $limiter->allowRequest($reqTime, 2));
        $this->assertEquals(0, $limiter->getCurrentTokens());
    }


    public function testRefillTokensTwo()
    {
        $lastReqTime = Carbon::parse('2020-01-01 00:01:00');
        $currentTokens = 0;
        $reqTime = Carbon::parse('2020-01-01 00:01:01');
        $rate = 1;
        $capacity = 100;

        $limiter = new TokenBucketLimiter($rate, $capacity);
        $limiter->setCurrentTokens($currentTokens)->setLastReqTime($lastReqTime);

        $this->assertEquals(false, $limiter->allowRequest($reqTime, 2));
        $this->assertEquals(1, $limiter->getCurrentTokens());
    }
}
