<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class SortingTest extends TestCase
{


    public function testExample()
    {

        $unsorted_numbers = array(3,7,1,26,43,12,6,21,23,73);
        $sorted_numbers = $this->quicksort($unsorted_numbers);

        dd($sorted_numbers);

    }


    public function quicksort($array)
    {
        if (count($array) == 0)
            return array();

        $pivot_element = $array[0];
        $left_element = $right_element = array();

        for ($i = 1; $i < count($array); $i++) {
            if ($array[$i] <$pivot_element)
                $left_element[] = $array[$i];
            else
                $right_element[] = $array[$i];
        }

        return array_merge($this->quicksort($left_element), array($pivot_element), $this->quicksort($right_element));
    }


}
