<?php

namespace App\Form\FormBuilder\Field\Validator;

class CaptchaValidator extends Validator
{
    private $code;

    public function __construct($breakOnFailure, array $options = array())
    {
        parent::__construct($breakOnFailure, $options);

        $this->code = $this->options['code'];
    }

    public function isValid($value)
    {
        return $value === $this->code;
    }

    public function getErrorMessage()
    {
        return 'Podano nieprawidłowy kod z obrazka.';
    }
}