<?php

namespace ApolloPY\Memcached;

use Memcached;
use RuntimeException;
use Illuminate\Cache\MemcachedConnector as AbstractMemcachedConnector;

class MemcachedConnector extends AbstractMemcachedConnector
{
    /**
     * Create a new Memcached connection.
     *
     * @param  array $servers
     * @param  array $config
     * @return \Memcached
     * @throws \RuntimeException
     */
    public function connect(array $servers, array $config = null)
    {
        $persistent_id = @$config['persistent_id'];
        $memcached = $this->getMemcached($persistent_id);

        if (count($memcached->getServerList()) > 0) {
            return $memcached;
        }

        if (isset($config['options']) && is_array($config['options'])) {
            $memcached->setOptions($config['options']);
        }

        $memcached_servers = [];
        foreach ($servers as $server) {
            $memcached_servers[] = [$server['host'], $server['port'], $server['weight']];
        }
        $memcached->addServers($memcached_servers);

        if (isset($config['username']) && ini_get('memcached.use_sasl') && method_exists($memcached, 'setSaslAuthData')) {
            $memcached->setSaslAuthData($config['username'], $config['password']);
        }

        if ((isset($config['check_version']) ? (bool) $config['check_version'] : true)) {
            $memcachedStatus = $memcached->getVersion();

            if (!is_array($memcachedStatus)) {
                throw new RuntimeException('No Memcached servers added.');
            }

            if (in_array('255.255.255', $memcachedStatus) && count(array_unique($memcachedStatus)) === 1) {
                throw new RuntimeException('Could not establish Memcached connection.');
            }
        }

        return $memcached;
    }

    /**
     * Get a new Memcached instance.
     *
     * @param null|string $persistent_id
     * @return \Memcached
     */
    protected function getMemcached($persistent_id = null)
    {
        return new Memcached($persistent_id);
    }
}
