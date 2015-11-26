<?php

namespace Dreamcoil;

class Phase 
{
	public $config, $translate;

	public function __construct()
	{

		$this->config = new \Dreamcoil\Config;

		$this->translate = new \Dreamcoil\Translate;

	}

}