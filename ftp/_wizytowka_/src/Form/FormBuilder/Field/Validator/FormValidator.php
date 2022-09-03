<?php

namespace App\Form\FormBuilder\Field\Validator;

use App\Factory\Factory;
use App\Form\Form;
use App\Form\FormBuilder\Field\Field;

class FormValidator
{
    public $form = null;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function isValid()
    {
        $isValid = true;
        $formBuilder = $this->form->getFormBuilder();

        /** @var Field $field */
        foreach($formBuilder->getFields() as $field)
        {
            $options = $field->getOptions();

            if(isset($options['validatorsDependency']))
            {
                foreach($options['validatorsDependency'] as $fieldName => $validatorDependencyValidator)
                {
                    if($this->hasErrors($this->checkConstraints(
                        $validatorDependencyValidator,
                        $formBuilder->getField($this->form->getFieldName($fieldName))->getValue()
                    ))) {
                        break 2;
                    }
                }
            }

            if(isset($options['validators']))
            {
                $field->setErrors($this->checkConstraints($options['validators'], $field->getValue()));
                $field->validated();
            }

            if($field->hasErrors())
            {
                $isValid = false;
            }
        }

        return $isValid;
    }

    private function hasErrors($errors)
    {
        return !empty($errors);
    }

    private function checkConstraints($validators, $value)
    {
        $errors = array();

        foreach($validators as $validator)
        {
            $class = $validator[0];
            unset($validator[0]);

            /** @var Validator $validator */
            $validator = Factory::getInstance($class, $validator);

            if(!$validator->isValid($value))
            {
                $errors[] = $validator->getErrorMessage();

                if($validator->getBreakOnFailure())
                {
                    break 1;
                }
            }
        }

        return $errors;
    }
}