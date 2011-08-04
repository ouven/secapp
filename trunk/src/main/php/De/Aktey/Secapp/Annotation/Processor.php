<?php

class De_Aktey_Secapp_Annotation_Processor {

	/** @var array */
	private $_observer= array();
	
	/**
	 * register an anotation observer for an annotation name
	 * 
	 * @param De_Aktey_Secapp_Annotation_Observer $obs
	 * @param string $name
	 */
	public function addAnnotationObserver(De_Aktey_Secapp_Annotation_Observer $obs= NULL) {
		if (is_null($obs)) return;
		$name= $obs->getName();
		if (!array_key_exists($name, $this->_observer)) {
			$this->_observer[$name]= array();
		}
		$this->_observer[$name][]= $obs;
	}

	/**
	 * process annotytions of an object
	 * @param Object $object
	 */
	public function process($object) {
		$clazz= new ReflectionClass($object);
		$this->_processAnnotations($object, $clazz, 'onClassAnnotation');
		foreach ($clazz->getProperties() as $prop) {
			$this->_processAnnotations($object, $prop, 'onPropertyAnnotation');
		}
		foreach ($clazz->getMethods() as $meth) {
			$this->_processAnnotations($object, $meth, 'onMethodAnnotation');
		}
	}

	private function _processAnnotations($object, $ref, $callback) {
		$doc= $ref->getDocComment();
		$annos = array();
		if (!preg_match_all('|\*\s*@(?<name>\w+)(\((?<param>[^\)]*)\))?|', $doc, $matches)) return $annos;
		foreach ($matches['name'] as $i => $name) {
			$annos[]= new De_Aktey_Secapp_Annotation_Annotation($name, $matches['param'][$i]);
		}

		foreach ($annos as $anno) {
			if (!array_key_exists($anno->getName(), $this->_observer)) continue;
			foreach($this->_observer[$anno->getName()] as $obs) {
				$obs->{$callback}($object, $ref, $anno);
			}
		}
	}
}