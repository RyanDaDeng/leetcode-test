<?php


namespace App\Modules\RateLimiterV2\CacheStore\Interfaces;


interface CacheStoreInterface
{
    public function fetch(
        string $key
    );

    public function save(
        string $key,
        array $data
    ): void;


    public function delete(
        string $key
    ): void;
}
