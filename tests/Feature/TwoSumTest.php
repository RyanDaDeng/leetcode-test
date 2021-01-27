<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Ramsey\Collection\Set;
use Tests\TestCase;

class TwoSumTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

    }


    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum($nums, $target) {

        $hashSet = [];
        foreach($nums as $key => $value){
            $hashSet[$value] = $key;
        }

        foreach($nums as $key => $value){
            $targetValue = $target - $value;

            if(isset($hashSet[$targetValue]) && $key != $hashSet[$targetValue]){
                return [$key, $hashSet[$targetValue] ];
            }
        }
        return [];
    }


}
