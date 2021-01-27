<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DesignHitCounterTest extends TestCase
{


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

//        // hit at timestamp 1.
//        $this->hit(1);
//
//// hit at timestamp 2.
//        $this->hit(2);
//
//// hit at timestamp 3.
//        $this->hit(3);
//
//// get hits at timestamp 4, should return 3.
//        $a = $this->getHits(4);
//
//// hit at timestamp 300.
//        $this->hit(300);
//
//// get hits at timestamp 300, should return 4.
//        $a = $this->getHits(300);

        $this->tokenBucket = [
            1 => 1,
            2 => 1,
            3 => 1,
            300 => 1
        ];

// get hits at timestamp 301, should return 3.
        $a = $this->getHits(301);
        dd($a);
        $this->assertTrue(true);


    }


    private $tokenBucket = [];
    private $interval = 300; //seconds

    /**
     * Record a hit.
     * @param timestamp - The current timestamp (in seconds granularity).
     * @param Integer $timestamp
     * @return NULL
     */
    public function hit($timestamp)
    {

        // get rid of tokens
        $this->cleanup($timestamp);

        // we add tokens
        if (!isset($this->tokenBucket[$timestamp])) {
            $this->tokenBucket[$timestamp] = 0;
        }
        $this->tokenBucket[$timestamp]++;
    }

    public function cleanup($timestamp)
    {
        // get rid of tokens
        $start = $timestamp - $this->interval;
        foreach ($this->tokenBucket as $timestampKey => $counter) {
            if ($timestampKey <= $start) {
                unset($this->tokenBucket[$timestampKey]);
            }
        }
    }

    /**
     * Return the number of hits in the past 5 minutes.
     * @param timestamp - The current timestamp (in seconds granularity).
     * @param Integer $timestamp
     * @return Integer
     */
    public function getHits($timestamp)
    {
        $this->cleanup($timestamp);
        return array_sum(array_values($this->tokenBucket));
    }

}
