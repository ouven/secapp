<?php

interface De_Aktey_Secapp_Annotation_Observer {
	
	/**
	 * name of the annotation to process
	 * 
	 * @return string
	 */
	public function getName();
	
	/**
	 * called for a property annotation
	 * 
	 * @param Object $instance
	 * @param ReflectionProperty $property
	 * @param De_Aktey_Secapp_Annotation_Annotation $annotation
	 */
	public function onPropertyAnnotation($instance, ReflectionProperty $property, De_Aktey_Secapp_Annotation_Annotation $annotation);

	/**
	 * called for a method annotation
	 * 
	 * @param Object $instance
	 * @param ReflectionMethod $method
	 * @param De_Aktey_Secapp_Annotation_Annotation $annotation
	 */
	public function onMethodAnnotation($instance, ReflectionMethod $method, De_Aktey_Secapp_Annotation_Annotation $annotation);

	/**
	 * called for a class annotation
	 * 
	 * @param Object $instance
	 * @param ReflectionClass $clazz
	 * @param De_Aktey_Secapp_Annotation_Annotation $annotation
	 */
	public function onClassAnnotation($instance, ReflectionClass $clazz, De_Aktey_Secapp_Annotation_Annotation $annotation);
}
