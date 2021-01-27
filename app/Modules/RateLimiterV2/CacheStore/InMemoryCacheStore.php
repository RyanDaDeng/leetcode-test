<?php


namespace App\Modules\RateLimiterV2\CacheStore;


use App\Modules\RateLimiterV2\CacheStore\Interfaces\CacheStoreInterface;

class InMemoryCacheStore implements CacheStoreInterface
{
    public $store = [];


    public function fetch(
        string $key
    )
    {
        if (!isset($this->store[$key])) {
            return null;
        }

        return $this->store[$key];
    }

    public function save(
        string $key,
        array $data
    ): void
    {
        $this->store[$key] = $data;
    }


    public function delete(
        string $key
    ): void
    {
        if (isset($this->store[$key])) {
            unset($this->store[$key]);
        }
    }

}
