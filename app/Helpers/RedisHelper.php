<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

class RedisHelper
{
    /**
     * @param $key
     * @param $value
     * @param int $timeout
     * @return bool
     */
    public static function set($key, $value, $timeout = 0)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }
        return $timeout == 0 ? Redis::set($key, $value) : self::setex($key, $timeout, $value);
    }

    /**
     * @param $key
     * @param $ttl
     * @param $value
     * @return bool
     */
    public static function setex($key, $ttl, $value)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }
        return Redis::setex($key, $ttl, $value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        $value = Redis::get($key);
        if (!$value) {
            return $value;
        }

        return Helper::isJson($value) ? json_decode(Redis::get($key), true) : Redis::get($key);
    }

    /**
     * Push a item to left of set
     * Item is json encoded before adding to set
     * @param $key
     * @param $value
     * @return int
     */
    public static function leftPush($key, $value)
    {
        $value = json_encode($value);
        return Redis::lPush($key, $value);
    }

    /**
     * Push a item to right of set
     * Item is json encoded before adding to set
     * @param $key
     * @param $value
     * @return int
     */
    public static function rightPush($key, $value)
    {
        $value = json_encode($value);
        return Redis::rPush($key, $value);
    }

    /**
     * @param $key
     * @return int
     */
    public static function del($key)
    {
        return Redis::del($key);
    }
}
