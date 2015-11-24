<?php

namespace ApolloPY\Memcached;

use Illuminate\Cache\MemcachedStore;
use Illuminate\Cache\CacheManager as AbstractCacheManager;

class CacheManager extends AbstractCacheManager
{
    /**
     * Create an instance of the Memcached cache driver.
     *
     * @param  array $config
     *
     * @return \Illuminate\Cache\MemcachedStore
     */
    protected function createMemcachedDriver(array $config)
    {
        $prefix = $this->getPrefix($config);

        $memcached = $this->app['memcached.connector']->connect($config['servers'], $config);

        return $this->repository(new MemcachedStore($memcached, $prefix));
    }
}
