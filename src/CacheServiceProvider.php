<?php

namespace ApolloPY\Memcached;

use Illuminate\Cache\CacheServiceProvider as ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('cache', function ($app) {
            return new CacheManager($app);
        });

        $this->app->singleton('memcached.connector', function () {
            return new MemcachedConnector;
        });
    }
}
