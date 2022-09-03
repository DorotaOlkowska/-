<?php

namespace App\View\ViewExtensions\Extensions;

use App\EventManager\Context;
use App\Service\Logger\Logger;
use App\Service\Logger\LoggerLevel;
use App\Service\Request\Request;
use App\Service\ServiceContainer\ServiceContainer;
use App\View\ViewExtensions\ViewExtension;

class ResourceExtension extends ViewExtension
{
    /** @var Logger $logger */
    private $logger;

    /**
     * ResourceExtension constructor.
     * @param Context $context
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);

        $this->serviceContainer = $context->getServiceContainer();
        $this->logger = $this->serviceContainer->getService('logger');
    }

    public function getFunctions()
    {
        return array(
            'getResourceFile' => array($this, 'getResourceFile'),
            'resourceUrl' => array($this, 'resourceUrl'),
            'baseUrl' => array($this, 'baseUrl'),
            'serverTechnicalUrl' => array($this, 'serverTechnicalUrl')
        );
    }

    /**
     * @param $templateName
     * @param $mediaResource
     * @return string
     */
    public function resourceUrl($templateName, $mediaResource)
    {
        $resourcesPath = $this->getServiceContainer()->getService('config')->resourcesPath;

        /** @var Request $request */
        $request = $this->getServiceContainer()->getService('request');

        return sprintf('%s%s/%s%s', $request->getBaseDir(), str_replace(WEB_DIR, '', $resourcesPath), $templateName, $mediaResource);
    }

    /**
     * @param $suffix
     * @return string
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function baseUrl($suffix = null)
    {
        return sprintf('%s%s', $this->getServiceContainer()->getService('request')->getBaseUrl(), $suffix);
    }

    /**
     * @param $resource
     * @return string
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function serverTechnicalUrl($resource)
    {
        $user = $this->getServiceContainer()->getService('request')->getEnv('USER');

        return $user ? (sprintf('//%s.nazwa.pl/_wizytowka_/public/', $user) . $resource) : $resource;
    }

    /**
     * @param $file
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\View\ViewException
     */
    public function getResourceFile($file)
    {
        $file = sprintf('%s/public/%s', APP_DIR, $file);

        if(file_exists($file))
        {
            $view = $this->context->getView();

            echo $view->render($file, $view->getParameters());
        }
        else
        {
            $this->logger->log(sprintf('File %s not found', $file), LoggerLevel::ERROR);
        }
    }
}