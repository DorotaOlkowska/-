<?php

namespace App\Controller;

use App\EventManager\Context;
use App\EventManager\ListenerInterface;
use App\Form\FormBuilder\FormBuilder;
use App\Service\BusinessCard\BusinessCard;
use App\Service\Config\Config;
use App\Service\Logger\Logger;
use App\Service\Request\Request;
use App\Service\ServiceInterface;
use App\Service\Session\Session;

abstract class Controller implements ListenerInterface
{
    protected $serviceContainer;
    /** @var \App\View\View $view */
    protected $view;
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->serviceContainer = $context->getServiceContainer();
        $this->view = $context->getView();
    }

    /**
     * @param $serviceName
     * @return ServiceInterface
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function getService($serviceName)
    {
        return $this->serviceContainer->getService($serviceName);
    }

    /**
     * @return FormBuilder
     */
    protected function getFormBuilder()
    {
        return new FormBuilder($this->serviceContainer);
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->serviceContainer->getService('request');
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->serviceContainer->getService('session');
    }

    /**
     * @return BusinessCard
     */
    protected function getBusinessCardService()
    {

        return $this->serviceContainer->getService('businessCard');
    }

    protected function previewEnabled()
    {
        return defined('PREVIEW_ENABLED')? PREVIEW_ENABLED : false;
    }

    protected function getForm($form, $options = array())
    {
        return new $form($options, $this->getFormBuilder());
    }

    /**
     * @return \App\Service\ServiceInterface
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function getAuthService()
    {
        return $this->getService('httpAuth');
    }

    /**
     * @return Logger
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function getLogger()
    {
        return $this->getService('logger');
    }

    /**
     * @return Config
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function getConfig()
    {
        return $this->getService('config');
    }
}
