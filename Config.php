<?php

namespace Dreamcoil;

class Config
{
    private $config;

    /**
     * Loads the config
     */
    public function __construct()
    {

        $file = __DIR__ . '/../app/_conf.php';

        $this->config = include $file;

    }

    /**
     * Gets the value for the config key
     * 
     * @param $key
     * @return null|string
     */
    public function get($key)
    {

        if(isset( $this->config[$key])) return $this->config[$key];

        $file = __DIR__ . '/../app/_conf.php';

        $config = include $file;

        if(isset($config[$key])) return $config[$key];

        return null;

    }

}
