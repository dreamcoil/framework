<?php

namespace Dreamcoil;

class Phase 
{
	public $config, $translate, $auth;

	public function __construct()
	{

		$this->config = new \Dreamcoil\Config;

		$this->translate = new \Dreamcoil\Translate;

        $this->auth = new \Dreamcoil\Auth();

	}

}
