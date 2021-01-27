<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class MinimumNumberTapsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $this->minTaps(5, [3, 4, 1, 1, 0, 0]);
    }

    /**
     * @param Integer $n
     * @param Integer[] $ranges
     * @return Integer
     */
    function minTaps($n, $ranges)
    {
        $clips = [];
        foreach ($ranges as $key=> $range) {
            $clips[] = [
                $key - $range,
                $key + $range
            ];
        }

        return $this->videoStitching($clips, $n);
    }


    /**
     * @param Integer[][] $clips
     * @param Integer $T
     * @return Integer
     */
    public function videoStitching($clips, $T)
    {

        $n = count($clips);
        $res = 0;
        usort($clips, function ($a, $b) {
            return $a[0] - $b[0];
        });

        $i = 0;
        $start = 0;
        $end = 0;


        while ($start < $T) {
            while ($i < $n && $clips[$i][0] <= $start) {
                $end = max($end, $clips[$i][1]);
                $i++;
            }
            if ($start == $end) return -1;
            $start = $end;
            $res++;
        }

        return $res;
    }
}
