<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Ramsey\Collection\Set;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        dd(3);
        $response = $this->get('/');

        $a = Collection::make([]);

        $this->A = [

            [0, 0, 0, 0, 0, 0],
            [0, 1, 0, 0, 0, 0],
            [1, 1, 0, 0, 0, 0],
            [1, 1, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0],
            [0, 0, 1, 1, 0, 0]

        ];
        $this->yMax = count($this->A[0]);
        $this->xMax = count($this->A);
        $this->fill($this->islandA, 1, 1);
        dd($this->islandA);
        $this->shortestBridge($this->A);

        $a->add([2, 1]);
        dd($a->contains([1, 2]));
        $response->assertStatus(200);
    }

    private $yMax;
    private $xMax;
    private $A;
    private $islandA = [];
    private $islandB = [];

    /**
     * @param Integer[][] $A
     * @return Integer
     */
    function shortestBridge($A)
    {
        $this->A = $A;
        $this->yMax = count($A[0]);
        $this->xMax = count($A);


        foreach ($A as $x => $row) {

            foreach ($row as $y => $value) {

                if ($value === 0) {
                    continue;
                }

                if (empty($this->islandA)) {
                    $this->fill($this->islandA, $x, $y);
                } elseif (empty($this->islandB) && !isset($this->islandA[$x . '_' . $y])) {
                    $this->fill($this->islandB, $x, $y);
                }

            }
        }

        $islandA = array_values($this->islandA);
        $islandB = array_values($this->islandB);

        $res = [];
        foreach ($islandA as $cor) {
            foreach ($islandB as $cor2) {
                $dist = abs($cor[0] - $cor2[0]) + abs($cor[1] - $cor2[1]);
                $res[] = $dist - 1;
            }
        }

        return min($res) < 0 ? 1 : min($res);
    }


    function fill(&$islandA, $x, $y)
    {
        $islandA[$x . '_' . $y] = [$x, $y];
        $adjacents = [
            $this->topAdjacent($x, $y),
            $this->leftAdjacent($x, $y),
            $this->rightAdjacent($x, $y),
            $this->botAdjacent($x, $y),
        ];

        foreach ($adjacents as $adjacent) {
            if ($adjacent !== false) {
                $newX = $adjacent[0];
                $newY = $adjacent[1];
                if ($this->A[$newX][$newY] === 1 && !isset($islandA[$newX . '_' . $newY])) {
                    $this->fill($islandA, $newX, $newY);
                }
            }
        }
    }

    function topAdjacent($x, $y)
    {
        if ($x - 1 < 0) {
            return false;
        }
        return [$x - 1, $y];
    }

    function leftAdjacent($x, $y)
    {
        if ($y - 1 < 0) {
            return false;
        }
        return [$x, $y - 1];
    }

    function rightAdjacent($x, $y)
    {
        if ($y + 1 >= $this->yMax) {
            return false;
        }
        return [$x, $y + 1];
    }

    function botAdjacent($x, $y)
    {
        if ($x + 1 >= $this->xMax) {
            return false;
        }
        return [$x + 1, $y];
    }

    /**
     * @param Integer $num
     * @return String
     */
    function intToRoman($num)
    {
        $map = [
            "M" => 1000,
            "CM" => 900,
            "D" => 500,
            "CD" => 400,
            "C" => 100,
            "XC" => 90,
            "L" => 50,
            "XL" => 40,
            "X" => 10,
            "IX" => 9,
            "V" => 5,
            "IV" => 4,
            "I" => 1
        ];

        $res = '';
        $tempNumber = $num;

        while (true) {
            foreach ($map as $key => $value) {
                if ($tempNumber - $value >= 0) {
                    $res .= $key;
                    $tempNumber = $tempNumber - $value;
                    break;
                }
            }

            if ($tempNumber === 0) {
                break;
            }
        }
        return $res;
    }
}
