<?php

namespace Dreamcoil;

class Auth
{

    /**
     * Creates an authentication session.
     * Uses auth_expire on the config to get the session lifetime.
     *
     * @param null $data
     */
    public function set($data = null)
    {

        $config = new Config();

        $hash = hash('ripemd160', microtime(true));

        if($config->get('auth_expire') !== null)
            $lifetime = $config->get('auth_expire');
        else
            $lifetime = ONE_DAY;

        session_set_cookie_params($lifetime,"/");

        if(session_id() == "") session_start();

        $lifetime += time();

        if(!isset($_COOKIE['auth-key'])) setcookie('auth-key', $hash,  $lifetime);

        if($data !== null) $_SESSION = $data;

    }

    /**
     * Checks if the user is authenitcated
     *
     * @return bool
     */
    public function check()
    {

        if(isset($_COOKIE['auth-key']))
            return true;
        else
            return false;

    }

    /**
     * Destroys a current function
     *
     * @return bool
     */
    public function destroy()
    {

        unset($_COOKIE['auth-key']);

        session_destroy();

        if($_COOKIE['auth-key'] === null) return true;

        return false;

    }

    /**
     * Starting a sessopn
     */
    public function start()
    {

        session_start();

    }

}
