<?php

namespace App\Form\FormBuilder\Field;

class Textarea extends Field
{
    public function renderViewHelper()
    {
        $value = isset($this->attributes['value'])? $this->attributes['value'] : null;
        unset($this->attributes['value']);

        return sprintf('<textarea %sname="%s">%s</textarea>', $this->getAttributesAsString(), $this->getName(), $value);
    }
}