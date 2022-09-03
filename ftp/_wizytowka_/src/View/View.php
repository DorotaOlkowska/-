<?php

namespace App\View;

use App\EventManager\Context;
use App\EventManager\EventManager;
use App\Service\Config\Config;
use App\Service\Logger\Logger;
use App\Service\Logger\LoggerLevel;
use App\Service\Request\Request;
use App\Service\ServiceContainer\ServiceContainer;
use App\View\ViewExtensions\ViewExtension;

class View
{
    private $serviceContainer;
    private $parameters = array();
    private $viewExtensionEventManager = array();

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
        $this->viewExtensionEventManager = new EventManager();
    }

    public function __set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function __get($name)
    {
        if (!isset($this->parameters[$name])) {
            $backtrace = debug_backtrace();
            $this->getLogger()
                ->log(sprintf('Variable \'%s\' does not exists in %s:%s', $name, $backtrace[0]['file'],
                    $backtrace[0]['line']),
                    LoggerLevel::ERROR
                );

            return null;
        }

        return $this->parameters[$name];
    }

    /**
     * @param $resource
     * @param array $parameters
     * @return null|string
     * @throws ViewException
     */
    public function render($resource, array $parameters = array())
    {
        $resourceFilename = $this->getResourceFilename($resource);

        if (!file_exists($resourceFilename)) {
            if (!file_exists($resource)) {
                throw new ViewException(sprintf('File \'%s\' not found', $resourceFilename));
            }

            $resourceFilename = $resource;
        }

        $this->parameters = array_merge($this->parameters, $parameters);
        ob_start();
        include $resourceFilename;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    private function getResourceFilename($resource)
    {
        return sprintf('%s/%s', $this->getConfig()->resourcesPath, $resource);
    }

    /**
     * @param $name
     * @param $arguments
     * @return null
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function __call($name, $arguments)
    {
        try {
            $context = new Context();
            $context
                ->setServiceContainer($this->serviceContainer)
                ->setView($this)
                ->setParameters($arguments);

            $this->viewExtensionEventManager->dispatch($name, $context);

            return $context->getResults();
        } catch (\Exception $exception) {
            $this->getLogger()->log(sprintf('View helper function \'%s\' not exists. %s:%s. %s', $name,
                $exception->getFile(), $exception->getLine(), $exception->getTraceAsString()), LoggerLevel::ERROR);

            return null;
        }
    }

    public function addExtension(ViewExtension $viewExtension)
    {
        $this->viewExtensionEventManager->addSubscriber($viewExtension->getSubscriber());

        return $this;
    }

    /**
     * @return Logger
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function getLogger()
    {
        return $this->serviceContainer->getService('logger');
    }

    /**
     * @return Config
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function getConfig()
    {
        return $this->serviceContainer->getService('config');
    }

    /**
     * @return Request
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function getRequest()
    {
        return $this->serviceContainer->getService('request');
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }
}