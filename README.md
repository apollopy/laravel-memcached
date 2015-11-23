# laravel-memcached

Memcached for Laravel 5.1, with persistent connection and sasl authentication support, compatible with aliyun osc.

## Installation

This service provider must be registered.

```php
// config/app.php

'providers' => [
    '...',
    ApolloPY\Memcached\MemcachedServiceProvider::class,
];
```

edit the config file: config/cache.php

```php
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
],
```
