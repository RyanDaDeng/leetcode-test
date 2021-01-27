<?php

namespace Tests\Unit;

use App\Modules\SimpleService\SimpleService;
use PHPUnit\Framework\TestCase;

class AtlassianTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testSimpleTest()
    {
        $service = new SimpleService();
        $a = 3;
        $b = 2;
        $res = $service->sub($a, $b);
        $this->assertEquals(1, $res);
    }
}
