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

		//Removes all GET parameters from request uri	
		$request_uri = $_SERVER['REQUEST_URI'];
		$request_uri = explode('?', $request_uri);
		$request_uri = $request_uri[0];
		
		//Removes GET parameters from route
		$better_route = explode('?', ROUTE);
		$better_route = $better_route[0];

		$route = $request_uri;

		if(ROUTE != '/' ) $route = str_replace($better_route, '', $request_uri);

		$path = $route . $url;

		for($i = 0;$i < 5; $i++) $path = str_replace('//', '/', $path);

		$protocol = 'https://';
		if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') $protocol = 'http://';
		if(is_null($full)) $protocol = '//';

		if($full || is_null($full)) return $protocol  . $_SERVER['SERVER_NAME'] . $path;

		return $path;

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

	/**
	 * Escapes German special character
	 *
	 * @param string $string
	 * @return string
	 */
	public function escapeGerman($string)
	{

		$string = str_replace(
		    		["Ä"     , "ä"     , "Ö"     ,  "ö"    , "Ü"     , "ü"     , "ß"] , 
		    		["&Auml;", "&auml;", "&Ouml;", "&ouml;", "&Uuml;", "&uuml;", "&szlig;"] , 
		    		$string);

		return $string;

	}

	/**
	 * Makes json more beatifull
	 *
	 * @param string $jsonString
	 * @return string
	 */
	public function beautifulJson($jsonString)
	{
		
		return str_replace(
			[","  ,"{"  ,"}"],
			[",\n","{\n","\n}"],
			$jsonString);
		
	}
	
	/**
	 * Checks if a bot crawls your page
	 * 
	 * @return bool
	 */
	public function isBot()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT']);
	}
    
}
