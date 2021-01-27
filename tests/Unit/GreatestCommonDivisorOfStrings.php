<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class GreatestCommonDivisorOfStrings extends TestCase
{


    public function testExample()
    {
        $res = $this->gcdOfStrings('ABCABC', 'ABC');
        dd($res,3%6,6%3);
    }

//    /**
//     * @param String $str1
//     * @param String $str2
//     * @return String
//     */
//    function gcdOfStrings($str1, $str2)
//    {
//        if (strlen($str1) > strlen($str2)) {
//            $splitStr = str_split($str2);
//        }else{
//            $splitStr = str_split($str1);
//        }
//
//
//    }

    function gcd($num1, $num2)
    {
        if ($num1 % $num2 == 0) {
            return $num2;
        } else {

            return $this->gcd($num2, $num1 % $num2);
        }
    }


    /**
     * @param String $str1
     * @param String $str2
     * @return String
     */
    function gcdOfStrings($str1, $str2)
    {
        if ($str1 . $str2 !== $str2 . $str1) return '';

        $strlen1 = strlen($str1);
        $strlen2 = strlen($str2);


        return substr($str1, 0, $this->gcd($strlen2,$strlen1));
    }
}
