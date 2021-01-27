<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class LetterCombinationTest extends TestCase
{


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $res = $this->letterCombinations("23");
        dd($res);
        $this->assertTrue(true);
    }

    private $splitDigits;
    private $mapper = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v',],
        9 => ['w', 'x', 'y', 'z']
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        if (empty($digits)) {
            return [];
        }

        $this->splitDigits = str_split($digits);
        return $this->recurseBuild($this->mapper[$this->splitDigits[0]], 1);
    }

    public function recurseBuild($res, $index = 1)
    {
        if (count($this->splitDigits) <= $index) {
            return $res;
        }
        $newPair = [];
        foreach ($res as $value) {
            foreach ($this->mapper[$this->splitDigits[$index]] as $value2) {
                $newPair[] = $value . $value2;
            }
        }
        $index++;
        return $this->recurseBuild($newPair, $index);
    }
}
