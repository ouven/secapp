<?php

/**
 * keep serializable
 * @author ruben
 */
class De_Aktey_Secapp_Application_Security_Principal {
	
	/** @var string */
	private $_username;
	
	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->_username;
	}
	
	/**
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->_username = $username;
	}
}