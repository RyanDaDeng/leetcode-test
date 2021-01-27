<?php

namespace Tests\Feature;

use App\Modules\RateLimiter\RuleLimiters\CounterLimiter;
use Carbon\Carbon;
use Tests\TestCase;

class CounterLimiterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWithinInterval()
    {
        // input
        $lastReqTime = Carbon::parse('2020-01-01 00:01:00');
        $counter = 99;
        $reqTime = Carbon::parse('2020-01-01 00:01:59');

        $limiter = new CounterLimiter(100, 60000);

        $shouldAllow = $limiter
            ->setLastReqTime($lastReqTime)
            ->setReqCounter($counter)
            ->allowRequest($reqTime);

        $this->assertEquals(true, $shouldAllow);
    }


    public function testMaxAttemptsWithinInterval()
    {
        // input
        $lastReqTime = Carbon::parse('2020-01-01 00:01:00');
        $counter = 100;
        $reqTime = Carbon::parse('2020-01-01 00:01:59');

        $limiter = new CounterLimiter(100, 60000);

        $shouldAllow = $limiter
            ->setLastReqTime($lastReqTime)
            ->setReqCounter($counter)
            ->allowRequest($reqTime);

        $this->assertEquals(false, $shouldAllow);
    }


    public function testNewIntervalReset()
    {
        // input
        $lastReqTime = Carbon::parse('2020-01-01 00:01:00');
        $counter = 100;
        $reqTime = Carbon::parse('2020-01-01 00:02:01');

        $limiter = new CounterLimiter(100, 60000);

        $shouldAllow = $limiter
            ->setLastReqTime($lastReqTime)
            ->setReqCounter($counter)
            ->allowRequest($reqTime);

        $this->assertEquals(true, $shouldAllow);
    }
}
