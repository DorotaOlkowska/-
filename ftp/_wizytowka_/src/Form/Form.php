<?php

namespace App\Form;

use App\Form\FormBuilder\Field\Validator\FormValidator;
use App\Form\FormBuilder\FormBuilder;
use App\Service\Request\Request;

abstract class Form
{
    /** @var FormBuilder $formBuilder */
    protected $formBuilder;
    protected $data = array();
    protected $attributes = array();
    protected $name = array();
    protected $options = array();

    /**
     * Form constructor.
     * @param $attributes
     * @param FormBuilder $formBuilder
     * @param array $options
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function __construct($attributes, FormBuilder $formBuilder, array $options = array())
    {
        $this->formBuilder = $formBuilder;
        $this->attributes = $attributes;
        $this->options = $options;

        $this->build();
        $this->applyDataFromRequest();
    }

    /**
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function applyDataFromRequest()
    {
        /** @var Request $request */
        $request = $this->formBuilder->getRequest();

        if (strtolower($this->attributes['method']) === strtolower($this->formBuilder->getRequest()->getRequestMethod())) {
            $this->data = $request->getPost($this->attributes['name']);
        } else {
            $this->data = $request->getQuery($this->attributes['name']);
        }

        $this->setDataToFields();
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function setDataToFields()
    {
        if ($this->data) {
            foreach ($this->data as $fieldName => $value) {
                $fieldFullName = $this->getFieldName($fieldName);
                if($this->formBuilder->hasField($fieldFullName)){
                    $this->formBuilder->getField($fieldFullName)->setValue($value);
                }
            }
        }

        return $this;
    }

    abstract protected function build();

    public function isValid()
    {
        $formValidator = new FormValidator($this);

        return $formValidator->isValid();
    }

    public function getFieldName($name)
    {
        return sprintf('%s[%s]', $this->attributes['name'], $name);
    }

    public function __get($field)
    {
        return $this->formBuilder->getField($this->getFieldName($field));
    }

    public function has($fieldName)
    {
        return $this->formBuilder->hasField($this->getFieldName($fieldName));
    }

    public function getFields()
    {
        return $this->formBuilder->getFields();
    }

    public function hasName()
    {
        return isset($this->attributes['name']) && !empty($this->attributes['name']);
    }

    public function getFormBuilder()
    {
        return $this->formBuilder;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    public function getAttribute($name, $default = null)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }
}