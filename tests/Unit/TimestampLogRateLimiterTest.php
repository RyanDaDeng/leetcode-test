<?php

namespace Tests\Unit;

use App\Modules\RateLimiterV2\RuleLimiters\TimestampLoggerLimiter;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TimestampLogRateLimiterTest extends TestCase
{


    public function testTimestampLogger()
    {
        $limit = 20;
        $interval = 60000; //ms
        $timestamp = [
            Carbon::parse('2020-01-01 00:00:30')->getTimestamp() => 18,

            Carbon::parse('2020-01-01 00:01:00')->getTimestamp() => 1,
            Carbon::parse('2020-01-01 00:01:10')->getTimestamp() => 1,
            Carbon::parse('2020-01-01 00:01:20')->getTimestamp() => 1,
        ];

        $reqTime = Carbon::parse('2020-01-01 00:01:59');

        $service = new TimestampLoggerLimiter($limit, $interval);
        $service->setTimestampMap($timestamp);
        $res = $service->allowRequest($reqTime);
        $this->assertTrue(true, $res);
        $this->assertEquals(4, $service->getCounter());
        $this->assertEquals(false, isset($res->timestamMap[Carbon::parse('2020-01-01 00:00:30')->getTimestamp()]));
    }


    public function testTimestampLoggerFailed()
    {
        $limit = 20;
        $interval = 60000; //ms
        $timestamp = [
            Carbon::parse('2020-01-01 00:00:30')->getTimestamp() => 18,

            Carbon::parse('2020-01-01 00:01:00')->getTimestamp() => 1,
            Carbon::parse('2020-01-01 00:01:10')->getTimestamp() => 1,
            Carbon::parse('2020-01-01 00:01:20')->getTimestamp() => 17,
        ];

        $reqTime = Carbon::parse('2020-01-01 00:01:59');

        $service = new TimestampLoggerLimiter($limit, $interval);
        $service->setTimestampMap($timestamp);
        $res = $service->allowRequest($reqTime);
        $this->assertTrue($res);
        $this->assertEquals(20, $service->getCounter());
        $this->assertEquals(false, isset($res->timestamMap[Carbon::parse('2020-01-01 00:00:30')->getTimestamp()]));


        $res = $service->allowRequest($reqTime);
        $this->assertEquals(false, $res);
        $this->assertEquals(20, $service->getCounter());
    }
}
