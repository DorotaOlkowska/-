<?php

namespace App\Service\ServiceContainer;

use App\Factory\Factory;
use App\Service\ServiceInterface;

class ServiceResolver
{
    private $serviceClass;
    private $serviceParameters;

    public function __construct($service, $serviceParameters)
    {
        $this->serviceClass = $service;
        $this->serviceParameters = $serviceParameters;
    }

    public function __invoke()
    {
        return Factory::getInstance($this->serviceClass, $this->serviceParameters);
    }
}