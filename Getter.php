<?php

namespace Dreamcoil;

class Getter
{

	private $error;
	
	public function constant($constant)
	{
	
		if(constant($constant) !== null) return constant($constant);
		
		$this->setError('Unknown constant');
		
		return null;
	
	}
	
	public function getError($error)
	{
		
		return $this->error;
		
	}
	
	private function setError($error)
	{
	
		$this->error = $error;
	
	}

}
