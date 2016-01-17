<?php

namespace Dreamcoil;

class Debug
{
	
	private $known_level = [LOG_INFO_TEXT, LOG_WARN_TEXT, LOG_ERROR_TEXT];
	
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
		
		if(in_array($level, $this->known_level))
		{

			if(is_string($info)) $dreamcoil_debug .= "\n " . $level . " " . date(DATE_RFC2822) . " : " . $info;
	
			else throw new \Exception("The debug text must to be a string");
		
		}
		else throw new \Exception("This debug level is unknown: " . $level);
		
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

		$dreamcoil_debug = str_replace('[ERROR]', '<span style="color: red">[ERROR]</span>', $dreamcoil_debug);

		return $dreamcoil_debug;

	}

}
