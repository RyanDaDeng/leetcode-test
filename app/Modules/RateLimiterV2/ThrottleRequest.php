<?php


namespace App\Modules\RateLimiterV2;


use App\Modules\RateLimiterV2\CacheStore\Interfaces\CacheStoreInterface;

class ThrottleRequest
{


    public function __construct(
        CacheStoreInterface $cacheStore
    )
    {

    }
}
