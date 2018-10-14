<?php
namespace common\phplib\redis;

class Redis {

	/**
	 * Holds initialized Redis connections.
	 *
	 * @var array
	 */
	protected static $connections = array();
	protected static $timeout = 0.2;

	/**
	 * By default the prefix of Redis key is the same as class name. But it
	 * can be specified manually.
	 *
	 * @var string
	 */
	protected static $prefix = NULL;
	protected static $debug = 1;

	protected static $configfile = 'redis';

	/**
	 * the server_id of the Redis Cluster
	 * @var int
	 */

    protected static function setTimeout($timeout) {
        self::$timeout = $timeout;
    }

	/**
	 * Initialize a Redis connection.
	 */
	protected static function connect($host, $port, $timeout = 0.2, $auth = '') {
	    $redis = new \Redis();
		$redis->connect($host, $port, $timeout);
        if (!empty($auth)) {
            $redis->auth($auth);
        }
        if ($redis->isConnected()) {
		    $redis->setOption(\Redis::OPT_READ_TIMEOUT, $timeout);
        }
		return $redis;
	}

	/**
	 * Get an initialized Redis connection according to the key.
	 */
	public static function getRedis($key = NULL, $reconnect = FALSE) {
		static $config = NULL;
		$class = get_called_class();
		is_null($config) && $config = \common\phplib\Config::load($class::$configfile);

        $servers = $config['servers'];
		$count = count($servers);
        $server_id = is_null($key) ? 0 : (hexdec(substr(md5($key), 0, 2)) % $count);
		$host = $servers[$server_id]['host'];
		$port = $servers[$server_id]['port'];
        $auth = isset($servers[$server_id]['auth']) ? $servers[$server_id]['auth'] : '';
		$connect_index = $host . ':' . $port;
        $is_connected = TRUE;

		if (!isset(self::$connections[$connect_index])) {
            self::$connections[$connect_index] = self::connect($host, $port, $class::$timeout, $auth);
            $is_connected = self::$connections[$connect_index]->isConnected();
            if (!$is_connected && !$reconnect) {
                unset(self::$connections[$connect_index]);
                return self::getRedis($key, TRUE);
            }
		}

        if (!$is_connected) {
            throw new \Exception ("Redis server went away");
        }
		return self::$connections[$connect_index];
	}

	protected static function getPrefix() {
		$class = get_called_class();
		if (!is_null($class::$prefix)) {
			return $class::$prefix;
		}
		return get_called_class();
	}

	protected static function getConfig() {
		$class = get_called_class();
		if (!empty($class::$config)) {
			return $class::$config;
		}
		return FALSE;
	}

    protected static $multiProcesser = NULL;

    public static function exec() {
        $ret = self::$multiProcesser->exec();
        self::$multiProcesser = null;
        return $ret;
    }

	public static function __callStatic($method, $args) {
		$class = get_called_class();
		$name = trim($args[0]);
		$key = self::_getKey($name);
		$args[0] = $key;
        try {
            $timer = array();
            $start = microtime(1);
            $redis = $class::getRedis($key); 
            $timer['connect'] = round(microtime(1) - $start, 3) * 1000;
            $start = microtime(1);
            $result = call_user_func_array(array($redis, $method), $args);
            $timer['exec'] = round(microtime(1) - $start, 3) * 1000;
            if ($timer['connect'] > 100 || $timer['exec'] > 100) {
            }
        }
        catch (\Exception $e) {
            $result = NULL;
        }
		return $result;
    }

	public static function _getKey($name) {
		$class = get_called_class ();
		$prefix = $class::getPrefix ();
		$key = "{$prefix}{$name}";
		return $key;
	}

}

