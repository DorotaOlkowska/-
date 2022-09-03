<?php

namespace App\Form\FormBuilder\Field\Validator;


class IsTrue extends Validator
{
    public function isValid($value)
    {
        return (bool)$value === true;
    }

    public function getErrorMessage()
    {
        return 'To pole musi być zaznaczone';
    }
}