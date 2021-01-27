<?php


namespace App\Modules\RateLimiterV2\RuleLimiters;


use App\Modules\RateLimiterV2\CacheStore\Interfaces\CacheStoreInterface;
use Carbon\Carbon;


class CounterLimiter
{
    private $key;
    private $storage;
    // config
    public $limit;
    public $interval; //ms


    public function __construct(
        string $key,
        int $limit,
        int $interval, //ms
        CacheStoreInterface $storage
    )
    {
        $this->key = $key;
        $this->limit = $limit;
        $this->interval = $interval;
        $this->storage = $storage;
    }

    public function allowRequest(?Carbon $requestTime = null): bool
    {
        $clientData = $this->storage->fetch($this->key);

        if (empty($clientData)) {
            $clientData = [
                'timer' => time(),
                'counter' => 0
            ];
        }

        if (!$requestTime) {
            $requestTime = Carbon::now();
        }

        $timer = Carbon::parse($clientData['timer']);

        if ($timer->addMilliseconds($this->interval)->greaterThan($requestTime)) {
            $clientData['counter']++;
            $this->storage->save($this->key, $clientData);
            return $clientData['counter'] <= $this->limit;
        } else {
            $clientData['counter'] = 1;
            $this->storage->save($this->key, $clientData);
            return true;
        }
    }
}
