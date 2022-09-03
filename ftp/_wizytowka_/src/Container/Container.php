<?php

namespace App\Container;

use App\EventManager\Context;
use App\EventManager\EventManager;
use App\EventManager\EventSubscriber;
use App\Response\Response;
use App\Service\Request\Request;
use App\Service\Router\Route;
use App\Service\Router\Router;
use App\Service\ServiceContainer\ServiceContainer;
use App\View\View;

class Container
{
    /**
     * @param ServiceContainer $serviceContainer
     * @param View $view
     * @return Response
     * @throws \App\Service\ServiceContainer\ServiceContainerException|\Exception
     */
    public function __invoke(ServiceContainer $serviceContainer, View $view)
    {
        /** @var Router $router */
        $router = $serviceContainer->getService('router');
        /** @var Route $route */

        $route = $router->getRoute();
        $eventManager = new EventManager();
        $eventManager->addSubscriber(new EventSubscriber($router->getRoutes()));

        $context = new Context();
        $context->setView($view)
            ->setServiceContainer($serviceContainer)
            ->setParameters($router->getParameters());

        if (!$route || !$eventManager->hasEvent($route->getName())) {
            throw new \Exception(sprintf('Route %s not found',
                $serviceContainer->getService('request')->getRequestUri()));
        }

        /** @var Request $request */
        $request = $serviceContainer->getService('request');

        $serviceContainer
            ->getService('logger')
            ->log(sprintf('%s Invoking matched Route %s %s:%s %s %s',
                $request->getRequestMethod(),
                $route->getName(),
                $route->getController(),
                $route->getAction(),
                ($request->getInput() ? print_r($request->getInput(), true) : ''),
                ($request->getPost() ? print_r($request->getPost(), true) : '')
            ));

        $eventManager->dispatch($route->getName(), $context);
        $serviceContainer->getService('session')->save();

        return $context->getResults();
    }
}