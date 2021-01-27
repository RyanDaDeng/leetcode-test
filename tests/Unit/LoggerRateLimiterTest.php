<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class LoggerRateLimiterTest extends TestCase
{


    public function testExample()
    {

    }


    private $mapper = [];

    /**
     * Returns true if the message should be printed in the given timestamp, otherwise returns false.
     * If this method returns false, the message will not be printed.
     * The timestamp is in seconds granularity.
     * @param Integer $timestamp
     * @param String $message
     * @return Boolean
     */
    function shouldPrintMessage($timestamp, $message)
    {

        if (!isset($this->mapper[$message])) {
            $this->mapper[$message] = $timestamp + 10;
            return true;
        }

        $aviabaleAt = $this->mapper[$message];

        if ($aviabaleAt <= $timestamp) {
            $this->mapper[$message] = $timestamp + 10;
            return true;
        } else {
            return false;
        }
    }

}
