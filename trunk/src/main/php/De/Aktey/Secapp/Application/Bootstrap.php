<?php

class De_Aktey_Secapp_Application_Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	/** @var De_Aktey_Secapp_Application_Dispatcher */
	private $_dispatcher;
	
	/**
	 * @see Zend_Application_Bootstrap_Bootstrap::__construct()
	 */
	public function __construct($application) {
		parent::__construct($application);
		$this->_dispatcher= new De_Aktey_Secapp_Application_Dispatcher();
	}

	/**
	 * @see Zend_Application_Bootstrap_BootstrapAbstract::run()
	 */
	public function run() {
		$sess= De_Aktey_Secapp_Application_Security_Context::getInstance()->getSession();
		$ap= $this->_dispatcher->getAnnotationProcessor();

		$ap->addAnnotationObserver(new De_Aktey_Secapp_Application_ResourceInjector($this));
		$ap->process($sess);
		$ap->addAnnotationObserver(new De_Aktey_Secapp_Application_Security());
		parent::run();
	}

	/**
	 * @see Zend_Application_Bootstrap_BootstrapAbstract::_bootstrap()
	 */
	protected function _bootstrap($resource) {
		Zend_Controller_Front::getInstance()->setDispatcher($this->_dispatcher);
		parent::_bootstrap($resource);
	}

	/**
	 * initialize session
	 */
	protected function _initSession() {
		Zend_Session::start();
	}
}