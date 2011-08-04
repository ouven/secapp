<?php

class De_Aktey_Secapp_Application_ResourceInjector extends De_Aktey_Secapp_Annotation_Observer_Abstract {

    private $_bootstrap;

    public function getName() {
        return 'inject';
    }

    /**
     * @param Zend_Application_Bootstrap_BootstrapAbstract $_bootstrap
     */
    public function __construct(Zend_Application_Bootstrap_BootstrapAbstract $_bootstrap) {
        $this->_bootstrap = $_bootstrap;
    }

    /**
     * @see De_Aktey_Secapp_Annotation_Observer::onPropertyAnnotation()
     * @throws De_Aktey_Secapp_Application_Resource_Exception
     */
    public function onPropertyAnnotation($instance, ReflectionProperty $property, De_Aktey_Secapp_Annotation_Annotation $annotation) {
        $resource = $this->_bootstrap->getResource($annotation->getBody());
        if (is_null($resource)) {
            throw new De_Aktey_Secapp_Application_Resource_Exception(sprintf('resource "%s" can not be fetched', $annotation->getBody()));
        }
        if (method_exists($property, 'setAccessible'))
            $property->setAccessible(true);
        
        $property->setValue($instance, $resource);
    }

}