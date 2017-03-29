<?php

namespace ApolloPY\Memcached;

use Illuminate\Cache\MemcachedStore as AbstractMemcachedStore;

/**
 * MemcachedStore class.
 *
 * @author ApolloPY <ApolloPY@Gmail.com>
 */
class MemcachedStore extends AbstractMemcachedStore
{
    /**
     * @param array $keys
     * @return array|bool
     */
    public function getMulti(array $keys)
    {
        $keys = array_map(function ($key) {
            return $this->prefix.$key;
        }, $keys);

        $values = $this->memcached->getMulti($keys);

        if ($this->memcached->getResultCode() == 0) {
            $value_keys = array_map(function ($key) {
                return substr($key, strlen($this->prefix));
            }, array_keys($values));

            return array_combine($value_keys, $values);
        }

        return false;
    }
}
