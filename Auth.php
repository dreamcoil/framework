<?php

namespace Dreamcoil;

class Auth
{

    public function set()
    {

        $hash = hash('ripemd160', microtime(true));

        if(isset(Dreamcoil\Config::get('auth_expire')))
            $lifetime = Dreamcoil\Config::get('auth_expire');
        else
            $lifetime = \Dreamcoil\ONE_DAY;


        if(!isset($_COOKIE['auth-key'])) setcookie('auth-key', $hash,  $lifetime);

        echo $hash;

    }

}
