<?php

namespace App\Form\FormBuilder\Field\Validator;


class Regex extends Validator
{
    private $pattern;

    public function __construct($breakOnFailure, array $options = array())
    {
        parent::__construct($breakOnFailure, $options);

        $this->pattern = $options['pattern'];
    }

    public function isValid($value)
    {
        return preg_match($this->pattern, $value);
    }

    public function getErrorMessage()
    {
        return 'Wprowadzona wartość jest błędna lub zbyt krótka.';
    }
}