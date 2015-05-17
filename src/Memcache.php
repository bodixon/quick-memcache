<?php
namespace QuickMemcache;

class Memcache extends \Memcache {

    public static function create($host, $port = null, $timeout = null) {
        $instance = new static();
        $res = @$instance->connect($host, $port, $timeout);

        if ($res === false) {
            throw new Exception\CannotConnectException("Can't connect to memcache");
        }

        return $instance;
    }

    public static function pcreate($host, $port = null, $timeout = null) {
        $instance = new static();
        $res = @$instance->pconnect($host, $port, $timeout);

        if ($res === false) {
            throw new Exception\CannotConnectException("Can't connect to memcache");
        }

        return $instance;
    }

    public function getOrSet($key, $value, $expire = null) {
        $result = $this->get($key);

        if ($result === false) {
            if (is_callable($value)) {
                $value = $value();
            }
            $this->set($key, $value, null, $expire);
            $result = $value;
        }

        return $result;
    }

    public function has($key) {
        return $this->get($key) !== false;
    }

}