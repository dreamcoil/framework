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
     * @return null|string|array|int
     */
    public function get($key)
    {
        global $dreamcoilLoadedConfig;
        
        if(!isset($dreamcoilLoadedConfig)) {
            $file = __DIR__ . '/../app/_conf.php';
            $dreamcoilLoadedConfig = include $file;
        }

        if(isset($dreamcoilLoadedConfig[$key])) return $dreamcoilLoadedConfig[$key];

        return null;
    }

}
