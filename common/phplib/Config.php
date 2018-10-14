<?php

namespace common\phplib;

use Yii;

abstract class Config
{
    public static function load($name)
    {
        static $configs;

        if (!isset($configs[$name])) {
            $name = strtolower($name);
            $path = Yii::$app->basePath . '/../common/config/' . YII_ENV;
            $file = $path . '/' . $name . '.php';
            if (file_exists($file)) {
                $configs[$name] = require($file);
            }
        }

        return $configs[$name];
    }

    ////////////////////////////////////////

    abstract protected function __construct();

    private $config;

    public function __get($name)
    {
        return $this->config[$name];
    }

    public function __set($name, $value)
    {
        $this->config[$name] = $value;
    }

    public function getConfig()
    {
        return $this->config;
    }
}

