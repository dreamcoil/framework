<?php

class Dreamcoil 
{

	public function url($url)
	{

		$route = str_replace(ROUTE, '', $_SERVER['REQUEST_URI']);

		return $route . $url;

	}

	public function __($key, $lang = null)
	{

		\Dreamcoil\Translate::say($key, $lang);

		return null;

	}
    
}
