<?php

namespace App\Service\ServiceContainer;

use App\Service\ServiceInterface;
use App\Service\ServiceParameters;

class ServiceContainer
{
    private $serviceContainer = array();
    private $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    /**
     * @param $serviceName
     * @return mixed
     * @throws ServiceContainerException
     */
    public function getService($serviceName)
    {
        if(!$this->serviceExists($serviceName))
        {
            throw new ServiceContainerException(sprintf('Service \'%s\' not found', $serviceName));
        }

        if(isset($this->serviceContainer[$serviceName]))
        {
            return $this->serviceContainer[$serviceName];
        }

        $this->loadService($serviceName);

        return $this->getService($serviceName);
    }

    /**
     * @param $serviceName
     * @throws ServiceContainerException
     */
    private function loadService($serviceName)
    {
        $parameters = array();
        $serviceParameters = new ServiceParameters($this->services[$serviceName]);

        foreach($serviceParameters->getParameters() as $parameter)
        {
            if(is_string($parameter) && substr($parameter, 0, 1) === '@')
            {
                $parameters[] = $this->serviceContainer[$serviceName] = $this->getService(ltrim($parameter, '@'));
            }
            else
            {
                $parameters[] = $parameter;
            }
        }

        $serviceResolver = new ServiceResolver($serviceParameters->getClassname(), $parameters);
        $this->serviceContainer[$serviceName] = $serviceResolver();
    }

    private function serviceExists($serviceName)
    {
        return isset($this->services[$serviceName]);
    }
}