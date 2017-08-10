<?php

namespace Dreamcoil;

class Config
{

    /**
     * Loads the config
     */
    public function __construct()
    {       
        global $dreamcoilLoadedConfig;
        
        $dreamcoilLoadedConfig = include __DIR__ . '/../app/_conf.php';
    }

    /**
     * Gets the value for the config key
     * 
     * @param $key
     * @return null|string|array|int
     */
    public static function get($key)
    {
        global $dreamcoilLoadedConfig;
        
        if(!isset($dreamcoilLoadedConfig)) {
            $file = __DIR__ . '/../app/_conf.php';
            $dreamcoilLoadedConfig = include $file;
        }

        if(isset($dreamcoilLoadedConfig[$key])) {
            return $dreamcoilLoadedConfig[$key];
        }

        return null;
    }

}
