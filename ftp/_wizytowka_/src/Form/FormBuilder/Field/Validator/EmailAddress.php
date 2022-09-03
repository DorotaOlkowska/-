<?php

namespace App\Form\FormBuilder\Field\Validator;

class EmailAddress extends Validator
{
    public function isValid($value)
    {
        return (filter_var($value, FILTER_VALIDATE_EMAIL) !== false);
    }

    public function getErrorMessage()
    {
        return 'Nieprawidłowy adres e-mail.';
    }
}