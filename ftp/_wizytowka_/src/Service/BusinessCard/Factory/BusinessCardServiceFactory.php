<?php

namespace App\Service\BusinessCard\Factory;

use App\Service\BusinessCard\Dao\JsonBusinessCardDaoDao;
use App\Service\BusinessCard\Datasource\File;
use App\Service\BusinessCard\Service\BusinessCardService;

class BusinessCardServiceFactory
{
    public static function create($file)
    {
        return new BusinessCardService(new JsonBusinessCardDaoDao(new File($file)));
    }
}