<?php
namespace backend\components;

use Yii;
use yii\mutex\Mutex;
use yii\redis\Connection;

class RedisMutex extends Mutex
{
    /**
     * Redis key prefix
     */
    public $prefix = 'redis-mutex:';
    /**
     * Redis instance
     */
    private $redis;

    /**
     * Initializes mutex component implementation using redis
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty(Yii::$app->cache->redis) || !Yii::$app->cache->redis instanceof Connection) {
            throw new InvalidConfigException('RedisMutex need use redis cache.');
        }
        $this->redis = Yii::$app->cache->redis;
    }

    /**
     * Get redis mutex key
     */
    public function getKey($name)
    {
        return $this->prefix . $name;
    }

    /**
     * Acquires lock by given name.
     * @param string $name of the lock to be acquired.
     * @param integer $timeout to wait for lock to become released.
     * @return boolean acquiring result.
     */
    protected function acquireLock($name, $timeout = 0)
    {
        $key = $this->getKey($name);
        $expire = (int) ((empty($timeout) ? 300 : $timeout) * 1000);
        return (boolean) $this->redis->executeCommand('SET', [$key, 1, 'NX', 'PX', $expire]);
    }

    /**
     * Releases lock by given name.
     * @param string $name of the lock to be released.
     * @return boolean release result.
     */
    protected function releaseLock($name)
    {
        $key = $this->getKey($name);
        return (boolean) $this->redis->executeCommand('DEL', $key);
    }
}
