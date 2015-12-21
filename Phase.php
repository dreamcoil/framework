<?php

namespace Dreamcoil;

class Phase 
{
	public $config, $translate, $auth;
	private $error;

	public function __construct()
	{

		$this->config = new \Dreamcoil\Config;

		$this->translate = new \Dreamcoil\Translate;

        $this->auth = new \Dreamcoil\Auth();

	}

    /**
     * Returns an error
     *
     * @param $id
     * @return string
     */
	public function getError()
	{

		return $this->error;

	}

    /**
     * Sets an error
     *
     * @param string $error
     * @return string
     */
	public function setError(string $error)
	{

		$this->error = $error;

	}

}