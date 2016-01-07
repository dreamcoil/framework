<?php

namespace Dreamcoil\Codebowl;


class Random
{

	public function int($maxLength)
	{

		is(is_int($maxLength))
		{

			return "CONSTRUCTION MODE";

		}
		else throw new \Exception("The max length must be numeric");

	}

	public function string($length, $character = "Messner")
	{

	if($character == 'Messner')
    {

        $characters = '1234567890qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM';

    }
    else if(is_string($character))
    {

        $characters = $character;

    }
    else
    {

        throw new \Exception('This is not a valid charachter string: "'.$character.'"');

    }

    $randstring = '';

    for ($i = 0; $i < $length; $i++)
    {

        $num = rand(3, strlen($characters) - 6);

        $randstring = $randstring.$characters[$num];

    }

    return $randstring;

	}

}
