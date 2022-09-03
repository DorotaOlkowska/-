<?php

namespace App\Form\FormBuilder\Field\Validator;

class InArray extends Validator
{
    public $array = array();
    public $value = '';

    public function __construct($breakOnFailure, array $options = array())
    {
        parent::__construct($breakOnFailure, $options);

        $this->array = isset($options['array']) ? $options['array'] : array();
    }

    public function isValid($value)
    {
        $this->value = $value;

        return in_array($value, $this->array);
    }

    public function getErrorMessage()
    {
        return sprintf('Wartość \'%s\' jest spoza oczekiwanego zakresu', $this->value);
    }
}