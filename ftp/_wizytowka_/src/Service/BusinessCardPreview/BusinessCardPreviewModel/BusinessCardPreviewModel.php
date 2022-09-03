<?php

namespace App\Service\BusinessCardPreview\BusinessCardPreviewModel;


class BusinessCardPreviewModel
{
    public $parameters;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameter($name, $default = null)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : $default;
    }
}