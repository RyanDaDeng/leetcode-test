<?php


namespace App\Modules\SimpleService;


class SimpleService
{

    public function add(int $numberOne, int $numberTwo): int
    {
        // @TODO
    }

    public function sub(int $a, int $b): int
    {
        $arrya = [
            1, 2, 3, 5
        ];
        foreach ($arrya as $item) {
            $item = $b + $this->someFunction();
        }
        return $a - $b;
    }


    public function someFunction()
    {
        $c = 2;
        $v= 2;
        return $c;
    }
}
