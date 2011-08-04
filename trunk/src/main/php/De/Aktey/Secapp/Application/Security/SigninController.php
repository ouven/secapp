<?php

class De_Aktey_Secapp_Application_Security_SigninController extends Zend_Controller_Action {

	/** @var Zend_Session_Namespace **/
	private $_sess;

	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
		parent::__construct($request, $response, $invokeArgs);
		$this->_registerSigninHelper();
		$this->_sess= new Zend_Session_Namespace(__CLASS__);
	}

	/**
	 * default
	 * - login formular
	 * - submit button
	 */
	public function indexAction() {
		$this->_sess->m= $this->getRequest()->getParam('m', $this->_sess->m ? $this->_sess->m : 'default');
		$this->_sess->c= $this->getRequest()->getParam('c', $this->_sess->c ? $this->_sess->c : 'index');
		$this->_sess->a= $this->getRequest()->getParam('a', $this->_sess->a ? $this->_sess->a : 'index');

		if (isset($this->_sess->fail)) {
			$this->view->fail= $this->_sess->fail;
			unset($this->_sess->fail);
		}
	}

	/**
	 * login action to submit the formular to
	 */
	public function loginAction() {
		$username= $this->getRequest()->getParam('username');
		$passwd= $this->getRequest()->getParam('password');

		if (empty($username)) {
			$this->_forward('index');
			return;
		}

		$a= 'index';
		$c= NULL;
		$m= NULL;
		$session= De_Aktey_Secapp_Application_Security_Context::getInstance()->getSession();
		try {
			$session->authenticate($username, $passwd);

			$a= $this->_sess->a;
			$c= $this->_sess->c;
			$m= $this->_sess->m;
			Zend_Session::namespaceUnset(__CLASS__);
		} catch (De_Aktey_Secapp_Application_Security_Authexception $ae) {
			$this->_sess->fail= $ae->getMessage();
		}
		$this->_helper->_redirector->gotoSimple($a, $c, $m);
	}

	/**
	 * destroy session
	 */
	public function logoutAction() {
		foreach (Zend_Session::getIterator() as $ns) Zend_Session::namespaceUnset($ns);
		$this->_forward('index');
	}

	/**
	 * register a signin view helper
	 * overwrite to set an other helper than the default
	 */
	protected function _registerSigninHelper() {
		$this->view->registerHelper(new De_Aktey_Secapp_Application_Security_SigninViewHelper(), 'signin');
	}
}