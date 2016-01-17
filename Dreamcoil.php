<?php

class Dreamcoil 
{

	/**
	 * Returns a relative/absolute URL
	 *
	 * @param $url
	 * @param bool|false $full decides if you want a relative or absolute URL
	 * @return string
	 */
	public function url($url, $full = false)
	{

		$route = $_SERVER['REQUEST_URI'];

		if(ROUTE != '/' ) $route = str_replace(ROUTE, '', $_SERVER['REQUEST_URI']);

		if(ROUTE == '/') $route = '';

		$route = str_replace('//', '/', $route);

		if($full) return 'http://'  . $_SERVER['SERVER_NAME'] . $route . $url;

		return $route . $url;

	}

	/**
	 * Echos a translation for given translation key
	 *
	 * @param $key
	 * @param null $lang
	 * @return null
	 */
	public function __($key, $lang = null)
	{

		\Dreamcoil\Translate::say($key, $lang);

		return null;

	}

	/**
	 * Returns an object
	 * @param array $array
	 * @return object
	 */
	public function toObject(array $array)
	{

		if(is_array($array)) return json_decode(json_encode($array));

		else throw new Exception("Only a array can be converted to an object");
	
	}
    
}
