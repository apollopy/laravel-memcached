<?php

namespace ApolloPY\Memcached;

use Memcached;
use ReflectionMethod;
use Illuminate\Cache\MemcachedStore as AbstractMemcachedStore;

/**
 * MemcachedStore class.
 *
 * @author ApolloPY <ApolloPY@Gmail.com>
 */
class MemcachedStore extends AbstractMemcachedStore
{
    /**
     * Indicates whether we are using Memcached version >= 3.0.0.
     *
     * @var bool
     */
    protected $onVersionThree;

    /**
     * Create a new Memcached store.
     *
     * @param  \Memcached $memcached
     * @param  string $prefix
     */
    public function __construct($memcached, $prefix = '')
    {
        parent::__construct($memcached, $prefix);

        $this->onVersionThree = (new ReflectionMethod('Memcached', 'getMulti'))
                                    ->getNumberOfParameters() == 2;
    }

    /**
     * Retrieve multiple items from the cache by key.
     * Items not found in the cache will have a null value.
     *
     * @param  array $keys
     * @return array
     */
    public function many(array $keys)
    {
        $prefixedKeys = array_map(function ($key) {
            return $this->prefix.$key;
        }, $keys);

        if ($this->onVersionThree) {
            $values = $this->memcached->getMulti($prefixedKeys, Memcached::GET_PRESERVE_ORDER);
        } else {
            $null = null;

            $values = $this->memcached->getMulti($prefixedKeys, $null, Memcached::GET_PRESERVE_ORDER);
        }

        if ($this->memcached->getResultCode() != 0) {
            return array_fill_keys($keys, null);
        }

        return array_combine($keys, $values);
    }

    /**
     * @deprecated use function many
     * @param array $keys
     * @return array
     */
    public function getMulti(array $keys)
    {
        return $this->many($keys);
    }
}
