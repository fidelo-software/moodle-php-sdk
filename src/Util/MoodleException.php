<?php

namespace MoodleSDK\Util;

class MoodleException extends \RuntimeException {
	
	private $payload;
	private $method;
	
	public function setPayload($payload) {
		$this->payload = $payload;
	}
	
	public function getPayload() {
		return $this->payload;
	}
	
	public function setMethod($method) {
		$this->method = $method;
	}
	
	public function getMethod() {
		return $this->method;
	}
	
}
