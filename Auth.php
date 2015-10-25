<?php

namespace Dreamcoil;

class Auth
{

    public function set()
    {

        $hash = hash('ripemd160', microtime(true));

        if(Config::get('auth_expire') !== null)
            $lifetime = Config::get('auth_expire');
        else
            $lifetime = ONE_DAY;


        if(!isset($_COOKIE['auth-key'])) setcookie('auth-key', $hash,  $lifetime);

        echo $hash;

    }

}
