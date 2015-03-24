<?php

class SecappDemo_Session extends De_Aktey_Secapp_Application_Security_Session {

    private static $userRolesMap = array(
        'userotto' => array('user'),
        'adminotto' => array('user', 'admin'),
    );

    /**
     * @override this to authenticate the user
     * Use resource injection shipped with this library to
     * authenticate against a database, an LDAP server or what ever you want.
     * Fill in the username if the authentication was valid or throw
     * a De_Aktey_Secapp_Application_Security_Authexception if not.
     * 
     * @param De_Aktey_Secapp_Application_Security_Principal $principal
     * @param type $username user to log in
     * @param type $password password to verify
     * @hrows De_Aktey_Secapp_Application_Security_Authexception
     */
    protected function _authenticate(De_Aktey_Secapp_Application_Security_Principal $principal, $username, $password) {
        if (!array_key_exists($username, self::$userRolesMap))
            throw new De_Aktey_Secapp_Application_Security_AuthException('Username and password does not match.');
        $principal->setUsername($username);
    }

    /**
     * @override to set the roles for a principal. the current authenticated principal
     * can be accessed by $this->getPrincipal(). a role is a simple string, which
     * should be added to the Roles object via $roles->addRole($role).
     * 
     * @param De_Aktey_Secapp_Application_Security_Roles $roles 
     */
    protected function _initRoles(De_Aktey_Secapp_Application_Security_Roles $roles) {
        $p = $this->getPrincipal();
        if (!array_key_exists($p->getUsername(), self::$userRolesMap))
            return;
        $roles->setRoles(self::$userRolesMap[$p->getUsername()]);
    }

    /**
     * redirect to the applications signin page
     * @param Zend_Controller_Action_Helper_Redirector $redirector
     * @param Zend_Controller_Request_Abstract $request
     */
    public function redirectSignin(Zend_Controller_Action_Helper_Redirector $redirector, Zend_Controller_Request_Abstract $request) {
        $redirector->gotoSimple('index', 'secure', 'default', array(
            'a' => $request->getActionName(),
            'c' => $request->getControllerName(),
            'm' => $request->getModuleName(),
        ));
    }
}
