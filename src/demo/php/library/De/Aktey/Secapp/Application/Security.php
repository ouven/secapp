<?php

class De_Aktey_Secapp_Application_Security extends De_Aktey_Secapp_Annotation_Observer_Abstract {

	/**
	 * @see De_Aktey_Secapp_Annotation_Observer::getName()
	 */
	public function getName() {
		return 'roles';
	}

	/**
	 * @see De_Aktey_Secapp_Annotation_Observer_Abstract::onClassAnnotation()
	 */
	public function onClassAnnotation($instance, ReflectionClass $clazz, De_Aktey_Secapp_Annotation_Annotation $annotation) {
		$this->_checkRole($instance, $annotation);
	}

	/**
	 * @see De_Aktey_Secapp_Annotation_Observer_Abstract::onClassAnnotation()
	 */
	public function onMethodAnnotation($instance, ReflectionMethod $method, De_Aktey_Secapp_Annotation_Annotation $annotation) {
		$this->_checkRole($instance, $annotation);
	}

	private function _checkRole($instance, De_Aktey_Secapp_Annotation_Annotation $annotation) {
		if (!($instance instanceof Zend_Controller_Action)) return;
		$sess= De_Aktey_Secapp_Application_Security_Context::getInstance()->getSession();
		if (!$sess->isAuthenticated()) {
			$sess= De_Aktey_Secapp_Application_Security_Context::getInstance()->getSession();
			$sess->redirectSignin($instance->getHelper('redirector'), $instance->getRequest());
			return;
		}

		$body= $annotation->getBody();
		if (!$body) return;

		$roles= explode(',', $body);
		$granted= $sess->getRoles();
		if (is_null($granted) || !$granted->hasAnyRole($roles)) {
			$sess->redirectForbidden($instance->getHelper('redirector'), $instance->getRequest());
		}
	}
}