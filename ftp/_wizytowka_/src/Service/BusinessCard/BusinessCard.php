<?php

namespace App\Service\BusinessCard;

use App\Service\BusinessCard\Factory\BusinessCardServiceFactory;
use App\Service\BusinessCard\Service\BusinessCardService;
use App\Service\ServiceInterface;

class BusinessCard implements ServiceInterface
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getBusinessCardCurrentService()
    {
        return BusinessCardServiceFactory::create($this->config['dataFile']);
    }

    public function getBusinessCardDefaultService()
    {
        return BusinessCardServiceFactory::create($this->config['dataFileDefault']);
    }
}