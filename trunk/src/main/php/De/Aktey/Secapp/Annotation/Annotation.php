<?php

class De_Aktey_Secapp_Annotation_Annotation {
	private $name;
	private $body;
	
	public function __construct($name, $body) {
		$this->name = $name;
		$this->body = $body;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}
}