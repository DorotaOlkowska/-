<?php

namespace App\Service\BusinessCardPreview;


use App\Service\BusinessCardPreview\BusinessCardPreviewModel\BusinessCardPreviewModel;
use App\Service\ServiceInterface;

class BusinessCardPreview implements ServiceInterface
{
    public function getPreviewModel(array $data)
    {
        return new BusinessCardPreviewModel($data);
    }
}