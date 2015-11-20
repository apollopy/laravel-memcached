# laravel-memcached

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
// 为了兼容默认的 memcached 配置格式, 扩展参数以 servers 的第一个 server 为准
[
    'host' => '127.0.0.1',
    'port' => 11211,
    'weight' => 100,
    
    // 持久化连接配置此参数
    'persistent_id' => 'mc',
    
    // 登录鉴权配置以下参数
    'username' => 'you username',
    'password' => 'you password',
],
```
