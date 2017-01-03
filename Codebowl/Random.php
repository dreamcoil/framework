<?php

namespace Dreamcoil\Codebowl;


class Random
{

	public static function int($maxLength)
	{
		if(is_int($maxLength))
		{
			return rand(0,floor(9.9999999999999*10^$mas_length));
		}
		else throw new \Exception("The max length must be numeric");
	}

	public static function string($length, $character = "Messner")
	{
		if($character == 'Messner') {
			$characters = '1234567890qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM';
	   	} else if(is_string($character)) {
			$characters = $character;
		} else {
			throw new \Exception('This is not a valid charachter string: "'.$character.'"');
		}

		$randstring = '';

		for ($i = 0; $i < $length; $i++) {
			$num = rand(3, strlen($characters) - 6);
			$randstring = $randstring.$characters[$num];
		}

		return $randstring;
	}

}
