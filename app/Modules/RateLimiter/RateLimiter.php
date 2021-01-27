<?php


namespace App\Modules\RateLimiter;


class RateLimiter
{


    /**
     * RateLimiter constructor.
     */
    public function __construct(
        CacheStore $cacheStore,
        RuleLimiter $ruleLimiter
    )
    {

    }


}
