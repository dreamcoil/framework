<?php

namespace Dreamcoil;

class Auth
{

    public function set($data = null)
    {

        $config = new Config();

        $hash = hash('ripemd160', microtime(true));

        if($config->get('auth_expire') !== null)
            $lifetime = $config->get('auth_expire');
        else
            $lifetime = ONE_DAY;

        session_set_cookie_params($lifetime,"/");

        session_start();

        $lifetime += time();

        if(!isset($_COOKIE['auth-key'])) setcookie('auth-key', $hash,  $lifetime);

        if($data !== null) $_SESSION = $data;

    }

    public function check()
    {

        if(isset($_COOKIE['auth-key']))
            return true;
        else
            return false;

    }

}
