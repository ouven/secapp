<?php

/**
 * resources can be injected in this class
 * 
 * @author ruben
 */
abstract class De_Aktey_Secapp_Application_Security_Session extends Zend_Session_Namespace {

	/** @var string */
	const SESSION_NAMESPACE= 'Secapp_Application_Security';

	/**
	 * @return De_Aktey_Secapp_Application_Security_Principal
	 */
	public function getPrincipal() {
		return $this->principal;
	}

	/**
	 * @param De_Aktey_Secapp_Application_Security_Principal $name
	 */
	public function setPrincipal(De_Aktey_Secapp_Application_Security_Principal $principal= null) {
		parent::__set('principal', $principal);
	}

	/**
	 * @return De_Aktey_Secapp_Application_Security_Roles
	 */
	public function getRoles() {
		return $this->roles;
	}

	/**
	 * @param De_Aktey_Secapp_Application_Security_Roles $roles
	 */
	public function setRoles(De_Aktey_Secapp_Application_Security_Roles $roles= null) {
		parent::__set('roles', $roles);
	}

	/**
	 * Session with namespace De_Aktey_Secapp_Application_Security::SESSION_NAMESPACE
	 * @see Zend_Session_Namespace::__construct()
	 */
	public function __construct() {
		parent::__construct(self::SESSION_NAMESPACE);
	}

	/**
	 * check if session is authenticated
	 * @return bool
	 */
	public function isAuthenticated() {
		return (isset($this->principal) && (!is_null($this->principal)));
	}

	/**
	 * call to authenticate the user
	 *
	 * @param string $username
	 * @param string $password
	 */
	public function authenticate($username, $password) {
		$principal = $this->_createPrincipal();
		$roles = $this->_createRoles();
		$this->setPrincipal(NULL);
		$this->setRoles(NULL);

		$this->_authenticate($principal, $username, $password);
		$this->setPrincipal($principal);
		$this->_initRoles($roles);
		$this->setRoles($roles);
	}

	/**
	 * redirect to signin page
	 * @param Zend_Controller_Action_Helper_Redirector $redirector
	 * @param Zend_Controller_Request_Abstract $request
	 */
	public function redirectSignin(Zend_Controller_Action_Helper_Redirector $redirector, Zend_Controller_Request_Abstract $request) {
		$redirector->gotoSimple('index', 'signin', 'security', array(
			'a' => $request->getActionName(),
			'c' => $request->getControllerName(),
			'm' => $request->getModuleName(),
		));
	}

	/**
	 * redirect to forbidden page
	 * @param Zend_Controller_Action_Helper_Redirector $redirector
	 * @param Zend_Controller_Request_Abstract $request
	 */
	public function redirectForbidden(Zend_Controller_Action_Helper_Redirector $redirector, Zend_Controller_Request_Abstract $request) {
		$redirector->gotoSimple('forbidden', 'error', 'default');
	}

	/**
         * @override this to authenticate the user
         * Use resource injection shipped with this library to
         * authenticate against a database, an LDAP server or what ever you want.
         * Fill in the username if the authentication was valid or throw
         * a De_Aktey_Secapp_Application_Security_Authexception if not.
         * 
	 * - authenticat a user and fill the principal
	 * - throw exception on failed signin
         * 
	 * @param De_Aktey_Secapp_Application_Security_Principal $principal
	 * @param string $username
	 * @param string $password
	 * @throws De_Aktey_Secapp_Application_Security_Authexception
	 */
	abstract protected function _authenticate(De_Aktey_Secapp_Application_Security_Principal $principal, $username, $password);

	/**
         * @override to set the roles for a principal. the current authenticated principal
         * can be accessed by $this->getPrincipal(). a role is a simple string, which
         * should be added to the Roles object via $roles->addRole($role).
         * 
	 * - add roles for a user
         * 
	 * @param De_Aktey_Secapp_Application_Security_Roles $roles
	 */
	abstract protected function _initRoles(De_Aktey_Secapp_Application_Security_Roles $roles);

	/**
	 * pricipal factory
	 * @return De_Aktey_Secapp_Application_Security_Principal
	 */
	protected function _createPrincipal() {
		return new De_Aktey_Secapp_Application_Security_Principal();
	}

	/**
	 * roles factory
	 * @return De_Aktey_Secapp_Application_Security_Roles
	 */
	protected function _createRoles() {
		return new De_Aktey_Secapp_Application_Security_Roles();
	}
}