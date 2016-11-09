<?php

namespace Dreamcoil\Codebowl;

class Verify
{

	public static function email($email)
	{

		if(filter_var($email, FILTER_VALIDATE_EMAIL) !== false) return true;

		return false;

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
