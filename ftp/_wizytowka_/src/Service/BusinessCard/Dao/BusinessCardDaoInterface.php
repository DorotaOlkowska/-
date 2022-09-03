<?php

namespace App\Service\BusinessCard\Dao;

use App\Service\BusinessCard\Model\BusinessCardModel;

interface BusinessCardDaoInterface
{
    public function save(BusinessCardModel $businessCard);
    public function get();
}