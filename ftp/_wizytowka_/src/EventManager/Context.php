<?php

namespace App\EventManager;

use App\Service\ServiceContainer\ServiceContainer;
use App\View\View;

class Context
{
    protected $serviceContainer;
    protected $view;
    protected $results;
    protected $parameters;


    public function getServiceContainer()
    {
        return $this->serviceContainer;
    }

    public function setServiceContainer(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;

        return $this;
    }

    public function setView(View $view)
    {
        $this->view = $view;

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}