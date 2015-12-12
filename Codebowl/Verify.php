<?php

namespace Dreamcoil\Codebowl;

class Verify
{

	public function email($email)
	{

		var_dump(filter_var($email, FILTER_VALIDATE_EMAIL));

	}

}