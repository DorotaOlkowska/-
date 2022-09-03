<?php

namespace App\Service\Router;

class Route
{
    private $controller;
    private $action;

    public function __construct($name, $route)
    {
        $this->name = $name;
        $this->controller = $route[0];
        $this->action = $route[1];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }
}