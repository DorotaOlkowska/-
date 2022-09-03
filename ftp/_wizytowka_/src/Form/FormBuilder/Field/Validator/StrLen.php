<?php

namespace App\Form\FormBuilder\Field\Validator;

class StrLen extends Validator
{
    private $max = null;
    private $min = null;

    public function __construct($breakOnFailure, array $options = array())
    {
        parent::__construct($breakOnFailure, $options);

        $this->max = isset($options['max'])? $options['max'] : null;
        $this->min = isset($options['min'])? $options['min'] : null;
    }

    public function isValid($value)
    {
        if($this->max)
        {
            if(strlen($value) > $this->max)
            {
                return false;
            }
        }

        if($this->min)
        {
            if(strlen($value) < $this->min)
            {
                return false;
            }
        }

        return true;
    }

    public function getErrorMessage()
    {
        if(!isset($this->min))
        {
            return 'Podana treść jest za długa';
        }

        if(!isset($this->max))
        {
            return 'Podana treść jest za krótka';
        }

        return sprintf('Podana tresć musi mieścić się w zakresie %s-%s  znaków', $this->min, $this->max);
    }
}