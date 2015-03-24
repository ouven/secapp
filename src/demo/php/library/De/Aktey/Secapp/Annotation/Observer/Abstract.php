<?php

abstract class De_Aktey_Secapp_Annotation_Observer_Abstract implements De_Aktey_Secapp_Annotation_Observer {
	
	/**
	 * @see De_Aktey_Secapp_Annotation_Observer::onPropertyAnnotation()
	 */
	public function onPropertyAnnotation($instance, ReflectionProperty $property, De_Aktey_Secapp_Annotation_Annotation $annotation) {}

	/**
	 * @see De_Aktey_Secapp_Annotation_Observer::onMethodAnnotation()
	 */
	public function onMethodAnnotation($instance, ReflectionMethod $method, De_Aktey_Secapp_Annotation_Annotation $annotation) {}

	/**
	 * @see De_Aktey_Secapp_Annotation_Observer::onClassAnnotation()
	 */
	public function onClassAnnotation($instance, ReflectionClass $clazz, De_Aktey_Secapp_Annotation_Annotation $annotation) {}
}
