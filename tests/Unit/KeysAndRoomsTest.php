<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class KeysAndRoomsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->canVisitAllRooms([[1],[2],[3],[]]);
        dd($this->map);
    }


    private $map = [];

    private $rooms;

    /**
     * @param Integer[][] $rooms
     * @return Boolean
     */
    public function canVisitAllRooms($rooms)
    {
        $this->rooms = $rooms;

        $this->visitRoom(0);

        return count($this->map) == count($rooms);
    }


    public function visitRoom($roomNumber)
    {
        if (isset($this->map[$roomNumber])) {
            return;
        }
        $this->map[$roomNumber] = 1;

        foreach ($this->rooms[$roomNumber] as $key) {
            $this->visitRoom($key);
        }
    }
}
