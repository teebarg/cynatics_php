<?php

namespace App\Models;

use App\Helpers\RedisHelper;
use Illuminate\Support\Facades\Redis;

class Session {

    /**
     * @var string
     */
    public $sessionId;

    /**
     * @var mixed
     */
    private $_session;

    /**
     * Session constructor.
     * @param $sessionId
     */
    public function __construct($sessionId) {
        $this->sessionId = $sessionId;
        $this->_session = RedisHelper::get($sessionId);
        if (!$this->_session) {
            RedisHelper::set($this->sessionId, $this);
        }
        $this->_setObjectValues();
    }

    private function _setObjectValues() {
        if (!empty($this->_session)) {
            foreach ($this->_session as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set($key, $value) {
        $this->$key = $value;
        RedisHelper::set($this->sessionId, $this);
    }

    /**
     * @param $key
     * @return bool|mixed
     */
    public function get($key) {
        if (isset($this->$key)) {
            return $this->$key;
        }
        return false;
    }

    /**
     * @param array $keys
     * @return $this
     */
    public function remove(array $keys) {
        foreach ($keys as $key) {
            if (isset($this->$key)) {
                unset($this->$key);
            }
        }

        RedisHelper::set($this->sessionId, $this);

        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function unsetKey($key) {
        if (isset($this->$key)) {
            unset($this->$key);
            RedisHelper::set($this->sessionId, $this);
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function delete() {
        $sessionId = $this->sessionId;

        foreach ($this as $key => $value) {
            unset($this->$key);
        }

        return RedisHelper::del($sessionId);
    }

    /**
     * Gets and unset a value from the session.
     *
     * @param string $key the key to fetch from session
     * @return mixed
     */
    public function pop(string $key) {
        $value = $this->get($key);
        $this->unsetKey($key);
        return $value;
    }

    /**
     * Get all the session data as an array.
     *
     */
    public function toArray() {
        return json_decode(Redis::get($this->sessionId), true);
    }

}
