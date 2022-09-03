<?php

namespace App\Service;

class ServiceParameters
{
    private $classname;
    private $parameters;

    public function __construct($parameters)
    {
        $this->classname = $parameters[0];
        $this->parameters = $parameters[1];
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getClassname()
    {
        return $this->classname;
    }
}