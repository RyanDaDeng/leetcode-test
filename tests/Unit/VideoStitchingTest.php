<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class VideoStitchingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $res = $this->videoStitching([
            [0, 2],
            [4, 6],
            [8, 10],
            [1, 5],
            [1, 9],
            [5, 9]
        ],
            10);

        dd($res);
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
