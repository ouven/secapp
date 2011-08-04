<?php

/**
 * mostly copied from Zend_Controller_Dispatcher_Standard
 * to extract the controller factory method
 */
class De_Aktey_Secapp_Application_Dispatcher extends Zend_Controller_Dispatcher_Standard {

	/** @var De_Aktey_Secapp_Annotation_Processor */
	private $_annotationProcessor;
	
	/**
	 * @return De_Aktey_Secapp_Annotation_Processor
	 */
	public function getAnnotationProcessor() {
		return $this->_annotationProcessor;
	}
	
	/**
	 * Constructor: Set current module to default value
	 *
	 * @param  array $params
	 * @return void
	 */
	public function __construct(array $params = array()) {
		parent::__construct($params);
		$this->_annotationProcessor= new De_Aktey_Secapp_Annotation_Processor();
	}

	public function dispatch(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response)
	{
		$this->setResponse($response);

		/**
		 * Get controller class
		 */
		if (!$this->isDispatchable($request)) {
			$controller = $request->getControllerName();
			if (!$this->getParam('useDefaultControllerAlways') && !empty($controller)) {
				require_once 'Zend/Controller/Dispatcher/Exception.php';
				throw new Zend_Controller_Dispatcher_Exception('Invalid controller specified (' . $request->getControllerName() . ')');
			}

			$className = $this->getDefaultControllerClass($request);
		} else {
			$className = $this->getControllerClass($request);
			if (!$className) {
				$className = $this->getDefaultControllerClass($request);
			}
		}

		/**
		 * Load the controller class file
		 */
		$className = $this->loadClass($className);

		/**
		 * Instantiate controller with request, response, and invocation
		 * arguments; throw exception if it's not an action controller
		 */
		$controller = $this->createControllerInstance($className, $request, $this->getResponse(), $this->getParams());
		if (!($controller instanceof Zend_Controller_Action_Interface) &&
		!($controller instanceof Zend_Controller_Action)) {
			require_once 'Zend/Controller/Dispatcher/Exception.php';
			throw new Zend_Controller_Dispatcher_Exception(
                'Controller "' . $className . '" is not an instance of Zend_Controller_Action_Interface'
                );
		}

		/**
		 * Retrieve the action name
		 */
		$action = $this->getActionMethod($request);

		/**
		 * Dispatch the method call
		 */
		$request->setDispatched(true);

		// by default, buffer output
		$disableOb = $this->getParam('disableOutputBuffering');
		$obLevel   = ob_get_level();
		if (empty($disableOb)) {
			ob_start();
		}

		try {
			$controller->dispatch($action);
		} catch (Exception $e) {
			// Clean output buffer on error
			$curObLevel = ob_get_level();
			if ($curObLevel > $obLevel) {
				do {
					ob_get_clean();
					$curObLevel = ob_get_level();
				} while ($curObLevel > $obLevel);
			}
			throw $e;
		}

		if (empty($disableOb)) {
			$content = ob_get_clean();
			$response->appendBody($content);
		}

		// Destroy the page controller instance and reflection objects
		$controller = null;
	}

	/**
	 * create the controller instance
	 *
	 * @param string $className
	 * @param Zend_Controller_Request_Abstract $request
	 * @param Zend_Controller_Response_Abstract $response
	 * @param array $params
	 */
	protected  function createControllerInstance($className, Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $params) {
		$controller= new $className($request, $response, $params);
		$this->_annotationProcessor->process($controller);
		return $controller;
	}
}