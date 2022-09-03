<?php

namespace App\Service\BusinessCard\Service;

use App\Service\BusinessCard\Dao\BusinessCardDaoInterface;
use App\Service\BusinessCard\Model\BusinessCardModel;

class BusinessCardService
{
    private $businessCardDao;

    /**
     * Application_Service_BusinessCard constructor.
     * @param BusinessCardDaoInterface $businessCardDao
     */
    public function __construct(BusinessCardDaoInterface $businessCardDao)
    {
        $this->businessCardDao = $businessCardDao;
    }

    /**
     * @param BusinessCardModel $businessCard
     * @return BusinessCardService
     */
    public function save(BusinessCardModel $businessCard)
    {
        $this->businessCardDao->save($businessCard);

        return $this;
    }

    /**
     * @return BusinessCardModel
     */
    public function get()
    {
        return $this->businessCardDao->get();
    }
}