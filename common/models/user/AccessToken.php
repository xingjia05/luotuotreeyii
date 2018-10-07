<?php
namespace common\models\user;

use common\phplib\redis\Redis;

class AccessToken extends Redis 
{

    public static function getAccessToken($name)
    {
        if (empty($name)) {
            return [];
        }
        $ret = self::get($name);
        if (empty($ret)) {
            return [];
        }
        return $ret;
    }

    public static function setAccessToken($name, $value, $expire)
    {
        if (empty($name) || empty($value)) {
            return false;
        }
        $ret = self::setex($name, $expire, $value);
        if (!$ret) {
            return false;
        }
        return true;
    }

    public static function getPrefix() 
    {
        return '';
    }
}
