<?php

class Dreamcoil 
{

	public function url($url, $full = false)
	{

		$route = $_SERVER['REQUEST_URI'];

		if(ROUTE != '/' ) $route = str_replace(ROUTE, '', $_SERVER['REQUEST_URI']);

		if($full) return 'http://'  . $_SERVER['SERVER_NAME'] . $route . $url;

		return $route . $url;

	}

	public function __($key, $lang = null)
	{

		\Dreamcoil\Translate::say($key, $lang);

		return null;

	}
    
}
