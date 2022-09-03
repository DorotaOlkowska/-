<?php

namespace App\Service\Router;

use App\Service\Request\Request;
use App\Service\ServiceInterface;

class Router implements ServiceInterface
{
    const ROUTE_PARAM_PATTERN = '/[\{|\[]([a-zA-Z0-9]+)[\}|\]]/';

    private $request;
    private $routes;
    private $route = null;
    private $parameters = array();

    public function __construct(Request $request, array $routes)
    {
        $this->request = $request;
        $this->routes = $routes;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRoute()
    {
        $this->matchSimpleRoute();
        $this->matchParameterValueRoute();

        return $this->route;
    }

    private function matchSimpleRoute()
    {
        if ($this->route) {
            return;
        }
        $requestUri = $this->request->getRequestUri();
        $requestParameters = array_filter(explode('/', $requestUri));
        foreach ($this->routes as $name => $route) {
            $this->parameters = array();
            $routeParameters = $this->getRouteParameters($name);
            if (sizeof($routeParameters) === sizeof($requestParameters)) {
                foreach ($requestParameters as $id => $requestParameter) {
                    if (isset($routeParameters[$id]) && $routeParameters[$id] !== $requestParameter) {
                        if (!preg_match(self::ROUTE_PARAM_PATTERN, $routeParameters[$id])) {
                            continue 2;
                        }
                        $this->parameters[] = $requestParameters[$id];
                    }
                }
                $this->route = new Route($name, $route);
                break;
            }
        }
    }

    private function matchParameterValueRoute()
    {
        if ($this->route) {
            return;
        }
        $requestUri = $this->request->getRequestUri();
        $requestParameters = array_filter(explode('/', $requestUri));
        foreach ($this->routes as $name => $route) {
            $routeParameters = $this->getRouteParameters($name);
            $routeParametersCount = count($routeParameters);
            foreach ($requestParameters as $id => $requestParameter) {
                if (isset($routeParameters[$id])) {
                    if ($routeParameters[$id] !== $requestParameter) {
                        if (!preg_match(self::ROUTE_PARAM_PATTERN, $routeParameters[$id])) {
                            continue 2;
                        }

                        if ($id !== $routeParametersCount) {
                            continue 2;
                        }
                        $this->parameters[] = $this->getKeyValueParameters($requestParameters, $id - 1);
                        $this->route = new Route($name, $route);
                        break 2;
                    }
                } else {
                    continue 2;
                }
            }
        }
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getControllerActionRoute($controller, $action, $parameters = array())
    {
        foreach ($this->routes as $route => $listener) {
            if (array($controller, $action) === $listener) {
                foreach ($parameters as $name => $value) {
                    $route = str_replace($name, $value, $route);
                }

                return $route;
            }
        }

        return null;
    }

    private function getRouteParameters($routeName)
    {
        return array_filter(explode('/', $routeName));
    }

    private function getKeyValueParameters($array, $sliceStart)
    {
        $array = array_slice(array_values($array), $sliceStart, sizeof($array));
        $arraySize = sizeof($array) - 1;
        $combined = array();
        if ($arraySize > 1) {
            foreach (range(0, $arraySize, 2) as $index) {
                $next = $index + 1;
                $combined[$array[$index]] = isset($array[$next]) ? $array[$next] : null;
            }
        } else {
            $combined[$array[0]] = isset($array[1]) ? $array[1] : null;
        }

        return $combined;
    }
}