<?php

namespace App;

use App\Container\Container;
use App\Response\ErrorResponse;
use App\Service\ServiceContainer\ServiceContainer;
use App\Response\Response;
use App\View\ViewFactory;

class App
{
    private $response;
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    /**
     * @return App
     * @throws \Exception
     */
    public function __invoke()
    {
        $serviceContainer = new ServiceContainer($this->services);
        $view = ViewFactory::getViewInstance($serviceContainer);

        try
        {
            $container = new Container();
            $this->response = $container($serviceContainer, $view);
        }
        catch(\Exception $e)
        {
            $this->response = new ErrorResponse(array('exception' => $e));
        }

        if($this->response->hasResource())
        {
            $this->response->setContents($view->render(
                $this->response->getResource(),
                $this->response->getParameters()
            ));
        }

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }
}