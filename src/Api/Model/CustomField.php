<?php

namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ModelBase;

class CustomField extends ModelBase 
{
	
	private $type;
	private $value;
	
	/**
	 * @param string $type
	 * @return $this
	 */
	public function setType(string $type) 
	{
		$this->type = $type;
		
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getType() 
	{
		return $this->type;
	}
	
	/**
	 * @param string $value
	 * @return $this
	 */
	public function setValue(string $value) 
	{
		$this->value = $value;
		
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getValue() 
	{
		return $this->value;
	}
	
}
