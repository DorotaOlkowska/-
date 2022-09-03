<?php

namespace App\Form\FormBuilder\Field;

abstract class Field
{
    private $name;
    protected $attributes = array();
    protected $options = array();
    private $errors = array();

    public function __construct($name, $attributes, $options = array())
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->options = $options;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;
    }

    public function getValue()
    {
        return isset($this->attributes['value']) ? $this->attributes['value'] : null;
    }

    protected function getAttributesAsString()
    {
        $string = '';

        foreach($this->attributes as $name => $value)
        {
            $string .= sprintf('%s="%s" ', $name, $value);
        }

        return $string;
    }

    public function renderErrors()
    {
        if($this->hasErrors())
        {
            $errors = '';
            foreach($this->errors as $error)
            {
                $errors .= sprintf('<li>%s</li>', $error);
            }

            return sprintf('<ul class="errors">%s</ul>', $errors);
        }

        return '';
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    abstract public function renderViewHelper();

    public function getOptions()
    {
        return $this->options;
    }

    public function validated()
    {

    }

    public function getOption($key, $default = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $default;
    }
}