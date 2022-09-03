<?php

namespace App\View;

use App\EventManager\Context;
use App\Factory\Factory;
use App\Service\ServiceContainer\ServiceContainer;
use App\View\ViewExtensions\Extensions\EscapeExtension;
use App\View\ViewExtensions\Extensions\ResourceExtension;

class ViewFactory
{
    /**
     * @param ServiceContainer $serviceContainer
     * @return View
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public static function getViewInstance(ServiceContainer $serviceContainer)
    {
        /** @var View $view */
        $view = Factory::getInstance('\App\View\View', array($serviceContainer));

        $context = new Context();
        $context->setServiceContainer($serviceContainer)
            ->setView($view);

        $view->addExtension(new ResourceExtension($context));
        $view->addExtension(new EscapeExtension());

        return $view;
    }
}