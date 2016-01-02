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

		if(is_string($info)) $dreamcoil_debug .= "\n " . $level . " " . date(DATE_RFC2822) . " " . $info;

		else throw new \Exception("The debug text must to be a string");
		

	}

	/**
	 * Gets the debug text
	 *
	 * @return string
	 */
	public function get($html = false)
	{
		global $dreamcoil_debug;

		if(!$html) return $dreamcoil_debug;

		$dreamcoil_debug = '<pre><code>' . $dreamcoil_debug . '</code></pre>';

		$dreamcoil_debug = str_replace('[info]', '<span style="color: blue">[info]</span>', $dreamcoil_debug);

		$dreamcoil_debug = str_replace('[Warn]', '<span style="color: orange">[Warn]</span>', $dreamcoil_debug);

		$dreamcoil_debug = str_replace('[ERROR]', '<span style="color: orange">[ERROR]</span>', $dreamcoil_debug);

		return $dreamcoil_debug;

	}

}
