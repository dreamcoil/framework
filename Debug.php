<?php

namespace Dreamcoil;

class Debug
{
	
	/**
	 * Adds an information to the debug console
	 * 
	 * @param string $info
	 * @param string $level
	 * @throw exception
	 */
	public function add($info, $level)
	{
		global $dreamcoil_debug;

		if(is_string($info)) $dreamcoil_debug .= "\n " $level . " " . date(DATE_RFC2822) . " " . $info;

		else throw new \Exception("The debug text must to be a string");
		

	}

	/**
	 * Gets the debug text
	 *
	 * @return string
	 */
	public function get()
	{
		global $dreamcoil_debug;

		return $dreamcoil_debug;

	}

}
