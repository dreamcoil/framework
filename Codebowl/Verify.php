<?php

namespace Dreamcoil\Codebowl;

class Verify
{

	public function email($email)
	{

		var_dump(filter_var($email, FILTER_VALIDATE_EMAIL));

	}

	public function password($password, $length = 6, $strength = 0)
	{

		if(strlen($password) >= $length)
		{

			switch ($strength)
			{

				case 0:
					return true;
					break;

				case 1:	
					if(preg_match("/([a-z])/g", $password) && preg_match("/([A-Z])/g", $password)) return true;
					return false;
					break;

				case 2:
					if(preg_match("/([a-z])/g", $password) && preg_match("/([A-Z])/g", $password) && preg_match("/([1-9])/g", $password)) return true;
					return false;
					break;

				case 3:
					if(preg_match("/(?=(.*[a-z])+)(?=(.*[0-9])+)[0-9a-zA-Z!\"#$%&'()*+,\-.\/:;<=>?@\[\\\]^_`{|}~]{" . $length . ",99}/g", $password)) return true;
					return false;
					break;
			}

		}
		else return false;

	}

}