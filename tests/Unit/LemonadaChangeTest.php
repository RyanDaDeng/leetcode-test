<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class LemonadaChangeTest extends TestCase
{


    public function testChange()
    {
        $this->lemonadeChange(
            [5,5,10,10,20]);
    }

    /**
     * @param Integer[] $bills
     * @return Boolean
     */
    function lemonadeChange($bills)
    {

        $pocket = [
            5 => 0,
            10 => 0,
            20 => 0
        ];


        foreach ($bills as $key => $bill) {

            if ($bill === 5) {
                $pocket[5]++;
            } elseif ($bill === 10) {
                $pocket[5]--;
                $pocket[10]++;
            } elseif ($bill === 20) {

                if ($pocket[5] > 0) {
                    if ($pocket[10] > 0) {
                        $pocket[5]--;
                        $pocket[10]--;
                    } else {
                        $pocket[5] = $pocket[5] - 3;
                    }
                }else{
                    return false;
                }
                $pocket[20]++;
            }

            if ($pocket[5] < 0 || $pocket[10] < 0) {
                return false;
            }
        }

        return true;
    }

}
