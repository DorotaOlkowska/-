<?php

namespace App\Service\BusinessCard\Dao;

use App\Service\BusinessCard\Datasource\File;
use App\Service\BusinessCard\Model\BusinessCardModel;

/**
 * Class Application_Dao_BusinessCard
 */
class JsonBusinessCardDaoDao implements BusinessCardDaoInterface
{
    private $dataSource;

    public function __construct(File $businessCardDataSource)
    {
        $this->dataSource = $businessCardDataSource;
    }

    /**
     * @param BusinessCardModel $businessCard
     * @throws \Exception
     */
    public function save(BusinessCardModel $businessCard)
    {
        $this->dataSource->save($businessCard->toJson());
    }

    /**
     * @return BusinessCardModel
     * @throws \Exception
     */
    public function get()
    {
        $businessCardData = json_decode($this->dataSource->get(), true);
        return new BusinessCardModel($businessCardData);
    }
}