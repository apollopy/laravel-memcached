# laravel-memcached

Memcached for Laravel 5.1, with persistent connection and sasl authentication support, compatible with aliyun osc.

## Installation

This service provider must be **replace**.

```php
// config/app.php

'providers' => [
    // Illuminate\Cache\CacheServiceProvider::class,
    '...',
    ApolloPY\Memcached\CacheServiceProvider::class,
];
```

edit the cache config

```php
// config/cache.php

'memcached' => [
    'driver'  => 'memcached',
    'servers' => [
        [
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
        ],
    ],
    'persistent_id' => 'you persistent id',
    'username' => 'you username',
    'password' => 'you password',
    'options'       => [ // optional
        Memcached::OPT_COMPRESSION     => false,
        Memcached::OPT_BINARY_PROTOCOL => true,
        ...
    ],
    'check_version' => false, // optional, default true
],
```
