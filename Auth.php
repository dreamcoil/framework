<?php

namespace Dreamcoil;

class Auth
{

    public function set()
    {

        $config = new Config();

        $hash = hash('ripemd160', microtime(true));

        if($config->get('auth_expire') !== null)
            $lifetime = $config->get('auth_expire');
        else
            $lifetime = ONE_DAY;

        $lifetime += time();

        if(!isset($_COOKIE['auth-key'])) setcookie('auth-key', $hash,  $lifetime);

        var_dump($lifetime);

    }

    public function check()
    {

        if(isset($_COOKIE['auth-key']))
            return true;
        else
            return false;

    }

}
