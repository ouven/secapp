<?php

class De_Aktey_Secapp_Application_Security_Roles {
	/** @ var array */
	private $_roles= array();

	/**
	 * @return array
	 */
	public function getRoles() {
		return array_keys($this->roles);
	}

	/**
	 * @param array $roles
	 */
	public function setRoles($roles) {
		$this->_roles= array_flip($roles);
	}

	/**
	 * add a role
	 * @param string $role
	 */
	public function addRole($role) {
		$this->_roles[$role]= true;
	}

	/**
	 * remove a role
	 * @param string $role
	 */
	public function removeRole($role) {
		if (array_key_exists($role, $this->_roles)) unset($this->_roles[$role]);
	}

	/**
	 * check for a role
	 * @param string $role
	 */
	public function hasRole($role) {
		return array_key_exists($role, $this->_roles);
	}

	/**
	 * check if any role is set
	 * @param array $roles
	 */
	public function hasAnyRole(array $roles) {
		foreach ($roles as $role) {
			if ($this->hasRole($role)) return TRUE;
		}
		return FALSE;
	}
}