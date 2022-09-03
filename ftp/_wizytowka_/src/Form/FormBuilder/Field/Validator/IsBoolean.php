<?php

namespace App\Form\FormBuilder\Field\Validator;


class IsBoolean extends Validator
{
    public function isValid($value)
    {
        return is_bool($value);
    }

    public function getErrorMessage()
    {
        return 'Nieprawidłowa wartość';
    }
}