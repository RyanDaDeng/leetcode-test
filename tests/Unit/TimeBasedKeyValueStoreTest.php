<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class TimeBasedKeyValueStoreTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $this->set("love", "high", 10);
        $this->set("love", "low", 20);
        $c = $this->get('love', 10);

        dd($c);
    }

    private $map;

    /**
     * @param String $key
     * @param String $value
     * @param Integer $timestamp
     * @return NULL
     */
    function set($key, $value, $timestamp)
    {

        if (!isset($this->map[$key])) {
            $this->map[$key] = [];

        }
        $this->map[$key][] = [
            'value' => $value,
            'timestamp' => $timestamp
        ];
    }

    /**
     * @param String $key
     * @param Integer $timestamp
     * @return String
     */
    function get($key, $timestamp)
    {
        // filter
//
//        Collection::make($this->map[$key])
//            ->where('timestamp', '<=', $timestamp)
//            ->sortByDesc('timestamp')
//            ->first();

//        dd($this->map);
        $filtered = [];
        $greatest = 0;
        $find = "";
        foreach ($this->map[$key] as $itemKey => $item) {

            if ($item['timestamp'] <= $timestamp) {
                if ($item['timestamp'] > $greatest) {
                    $greatest = $item['timestamp'];
                    $find = $itemKey;
                }
            }
        }

        // 1 ,2 3,5 ,6,7,8,9,10,11
        $index = $this->binarySearch($this->map[$key], $timestamp);

        return $index === null ? "" : $this->map[$key][$index]['value'] ;
    }


    public function binarySearch(array $arr, $x)
    {
        // check for empty array
        if (count($arr) === 0) return false;
        $low = 0;
        $high = count($arr) - 1;

        $highest = null;
        while ($low <= $high) {

            // compute middle index
            $mid = floor(($low + $high) / 2);

            // element found at mid
            if ($arr[$mid]['timestamp'] == $x) {
                return $mid;
            }

            if ($x < $arr[$mid]['timestamp']) {
                // search the left side of the array
                $high = $mid - 1;
            } else {
                // search the right side of the array
                $low = $mid + 1;
                $highest = $mid;
            }
        }

        // If we reach here element x doesnt exist
        return $highest === null ? null : (int) $highest;
    }
}
