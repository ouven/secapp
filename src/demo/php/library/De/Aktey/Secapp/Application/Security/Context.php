<?php

/**
 * security entry point
 * 
 * @author ruben
 */
class De_Aktey_Secapp_Application_Security_Context {

	/**
	 * @see De_Aktey_Secapp_Application::__construct()
	 * @see De_Aktey_Secapp_Application::getSessionClassName()
	 * @var De_Aktey_Secapp_Application_Security_Session
	 */
	public static $sessionClassName= 'De_Aktey_Secapp_Application_Security_Session';

	/** @var De_Aktey_Secapp_Application_Security_Context */
	private static $_inst= NULL;

	/** @var De_Aktey_Secapp_Application_Security_Session */
	private static $_session= NULL;

	/**
	 * @return De_Aktey_Secapp_Application_Security_Session
	 */
	public function getSession() {
		return $this->_session;
	}

	/**
	 * @param De_Aktey_Secapp_Application_Security_Session $session
	 */
	public function setSession(De_Aktey_Secapp_Application_Security_Session $session) {
		$this->_session = $session;
	}

	/**
	 * @return De_Aktey_Secapp_Application_Security_Context
	 */
	public static function getInstance() {
		if (is_null(self::$_inst)) {
			$s= new self();
			self::$_inst= $s;
			$s->setSession(new self::$sessionClassName());
		}
		return self::$_inst;
	}
	
	/**
	 * delegate to session
	 * @see De_Aktey_Secapp_Application_Security_Session::isAuthenticated()
	 */
	public static function isAuthenticated() {
		return self::getInstance()->getSession()->isAuthenticated();
	}
	
	/**
	 * delegate to session
	 * @see De_Aktey_Secapp_Application_Security_Session::getRoles()
	 */
	public static function getRoles() {
		return self::getInstance()->getSession()->getRoles();
	}
	
	/**
	 * delegate to session
	 * @see De_Aktey_Secapp_Application_Security_Session::getPrincipal()
	 */
	public static function getPrincipal() {
		return self::getInstance()->getSession()->getPrincipal();
	}
}