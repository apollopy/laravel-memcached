<?php

namespace ApolloPY\Memcached;

use Memcached;
use RuntimeException;

class MemcachedConnector
{
    /**
     * Create a new Memcached connection.
     *
     * @param  array  $servers
     * @return \Memcached
     *
     * @throws \RuntimeException
     */
    public function connect(array $servers)
    {
        $persistent_id = @$servers[0]['persistent_id'];
        $memcached = $this->getMemcached($persistent_id);

        if (count($memcached->getServerList()) > 0) {
            return $memcached;
        }

        $memcached_servers = [];
        foreach ($servers as $server) {
            $memcached_servers[] = [$server['host'], $server['port'], $server['weight']];
        }
        $memcached->addServers($memcached_servers);

        if(isset($servers[0]['username']) && ini_get('memcached.use_sasl')) {
            $memcached->setSaslAuthData($servers[0]['username'], $servers[0]['password']);
        }

        $memcachedStatus = $memcached->getVersion();
        if (! is_array($memcachedStatus)) {
            throw new RuntimeException('No Memcached servers added.');
        }

        return $memcached;
    }

    /**
     * Get a new Memcached instance.
     *
     * @return \Memcached
     */

    /**
     * @param null|string $persistent_id
     * @return \Memcached
     */
    protected function getMemcached($persistent_id = null)
    {
        return new Memcached($persistent_id);
    }
}
