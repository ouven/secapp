<?php
require 'Zend/Application.php';

abstract class De_Aktey_Secapp_Application extends Zend_Application {

	/**
	 * @see Zend_Application::__construct()
	 */
	public function __construct($environment, $options= NULL) {
		parent::__construct($environment, $options);
		De_Aktey_Secapp_Application_Security_Context::$sessionClassName= $this->getSessionClassName(); 
	}
	
	/**
	 * @overwrite
	 * - get the name of the session class
	 * @return string
	 */
	abstract public function getSessionClassName();
}
