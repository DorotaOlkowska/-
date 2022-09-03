<?php

namespace App\Form\FormBuilder\Field\Validator;

abstract class Validator
{
    protected $breakOnFailure = false;
    protected $options = array();

    public function __construct($breakOnFailure, array $options = array())
    {
        $this->breakOnFailure = $breakOnFailure;
        $this->options = $options;
    }

    public function getBreakOnFailure()
    {
        return $this->breakOnFailure;
    }

    abstract public function isValid($value);

    abstract public function getErrorMessage();
}