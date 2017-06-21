<?php

namespace Dreamcoil\Codebowl;

class Verify
{

	public static function email($email)
	{
		// Email Address Regular Expression That 99.99% Works
		// taken from http://emailregex.com/
		return preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $email);
	}

	public static function password($password, $length = 6, $strength = 0)
	{

		if(strlen($password) >= $length)
		{

			switch ($strength)
			{

				case 0:
					return true;
					break;

				case 1:	
					if(preg_match("/([a-z])/", $password) && preg_match("/([A-Z])/", $password)) return true;
					return false;
					break;

				case 2:
					if(preg_match("/([a-z])/", $password) && preg_match("/([A-Z])/", $password) && preg_match("/([1-9])/", $password)) return true;
					return false;
					break;

				case 3:
					if(preg_match("/(?=(.*[a-z])+)(?=(.*[0-9])+)[0-9a-zA-Z!\"#$%&'()*+,\-.\/:;<=>?@\[\\\]^_`{|}~]{" . $length . ",99}/", $password)) return true;
					return false;
					break;
			}

		}
		else return false;

	}

	public static function name($name)
	{

		if(preg_match("/((\b[A-Z,ü,ö,ä]{1}[a-z,ü,ö,ä]{2,}).){2,}/", $name)) return true;

		return false;

	}

	public static function timestamp($timestamp)
	{

		if($timestamp <= time() && $timestamp > time() / 2 && is_numeric($timestamp)) return true;

		return false;

	}
	
	public static function date($string)
	{
		
		if($string == "") return true;
		
		return strtotime($string);
	}

	public static function statement($statement)
	{

		if($statement == "yes" || $statement == "no") return true;

		return false;

	}

}
