<?php

namespace Tests\Feature;

use App\Modules\RateLimiterV2\CacheStore\InMemoryCacheStore;
use App\Modules\RateLimiterV2\RuleLimiters\CounterLimiter;
use Carbon\Carbon;
use Tests\TestCase;

class CounterLimiterV2Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWithinInterval()
    {
        // input

        $reqTime = Carbon::parse('2020-01-01 00:01:59');

        $storage = new InMemoryCacheStore();
        $storage->save(
            'test',
            [
                'timer' => Carbon::parse('2020-01-01 00:01:00')->getTimestamp(),
                'counter' => 99
            ]
        );

        $limiter = new CounterLimiter('test', 100, 60000, $storage);
        $shouldAllow = $limiter->allowRequest($reqTime);
        $this->assertEquals(true, $shouldAllow);
    }


    public function testMaxAttemptsWithinInterval()
    {
        // input
        $reqTime = Carbon::parse('2020-01-01 00:01:59');
        $storage = new InMemoryCacheStore();
        $storage->save(
            'test',
            [
                'timer' => Carbon::parse('2020-01-01 00:01:00')->getTimestamp(),
                'counter' => 100
            ]
        );


        $limiter = new CounterLimiter('test', 100, 60000, $storage);

        $shouldAllow = $limiter->allowRequest($reqTime);

        $this->assertEquals(false, $shouldAllow);
    }


    public function testNewIntervalReset()
    {
        // input

        $reqTime = Carbon::parse('2020-01-01 00:02:01');

        $storage = new InMemoryCacheStore();
        $storage->save(
            'test',
            [
                'timer' => Carbon::parse('2020-01-01 00:01:00')->getTimestamp(),
                'counter' => 100
            ]
        );

        $limiter = new CounterLimiter('test', 100, 60000, $storage);

        $shouldAllow = $limiter
            ->allowRequest($reqTime);

        $this->assertEquals(true, $shouldAllow);
    }
}
