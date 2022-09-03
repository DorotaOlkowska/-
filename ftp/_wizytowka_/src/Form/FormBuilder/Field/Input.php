<?php

namespace App\Form\FormBuilder\Field;

class Input extends Field
{
    public function renderViewHelper()
    {
        return sprintf('<input %sname="%s"/>', $this->getAttributesAsString(), $this->getName(), $this->getName());
    }
}