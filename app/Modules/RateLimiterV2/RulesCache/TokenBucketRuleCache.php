<?php


namespace App\Modules\RateLimiterV2\RulesCache;


use App\Modules\RateLimiterV2\CacheStore\Interfaces\CacheStoreInterface;

class TokenBucketRuleCache
{

    private $cacheStore;

    public function __construct(
        CacheStoreInterface $cacheStore
    )
    {
        $this->cacheStore = $cacheStore;
    }

    public function consumeTokens($key, $token)
    {
        $this->cacheStore->store[$key] -= $token;
    }
}
