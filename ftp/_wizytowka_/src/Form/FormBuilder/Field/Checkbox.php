<?php

namespace App\Form\FormBuilder\Field;

class Checkbox extends Input
{
    public function renderViewHelper()
    {
        $id = $this->getAttribute('id');
        $label = $this->getOption('label');
        $label = sprintf('<label for="%s" class="label_%s"><p>%s</p></label>', $id, $id, $label);

        return sprintf('%s%s', parent::renderViewHelper(), $label);
    }

    private function getAttribute($name, $default = null)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }
}