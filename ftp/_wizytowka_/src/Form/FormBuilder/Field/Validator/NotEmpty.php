<?php

namespace App\Form\FormBuilder\Field\Validator;

class NotEmpty extends Validator
{
    public function isValid($value)
    {
        return !empty($value) &&  $value != '';
    }

    public function getErrorMessage()
    {
        return 'To pole jest wymagane.';
    }
}