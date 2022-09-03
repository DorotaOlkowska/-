<?php

namespace App\Form\FormBuilder;

use App\Form\FormBuilder\Field\Field;
use App\Service\Request\Request;
use App\Service\ServiceContainer\ServiceContainer;
use App\Service\ServiceInterface;

class FormBuilder
{
    private $serviceContainer;
    private $fields;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    public function addField(Field $field)
    {
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    public function getField($name)
    {
        return $this->fields[$name];
    }

    public function hasField($name)
    {
        return isset($this->fields[$name]);
    }

    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return Request
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function getRequest()
    {
        return $this->serviceContainer->getService('request');
    }

    public function getServiceContainer()
    {
        return $this->serviceContainer;
    }
}