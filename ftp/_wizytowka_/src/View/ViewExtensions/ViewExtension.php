<?php

namespace App\View\ViewExtensions;

use App\EventManager\Context;
use App\EventManager\EventSubscriber;
use App\Service\ServiceContainer\ServiceContainer;

abstract class ViewExtension
{
    protected $serviceContainer;
    protected $subscriber;
    protected $context;

    public function __construct(Context $context = null)
    {
        $this->subscriber = new EventSubscriber($this->getFunctions());
        $this->context = $context;
    }

    public function getSubscriber()
    {
        return $this->subscriber;
    }

    protected function getServiceContainer()
    {
        return $this->context->getServiceContainer();
    }

    abstract public function getFunctions();
}