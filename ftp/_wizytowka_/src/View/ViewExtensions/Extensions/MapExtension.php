<?php

namespace App\View\ViewExtensions\Extensions;

use App\View\ViewExtensions\ViewExtension;

class MapExtension extends ViewExtension
{
    CONST GLOBAL_GOOGLE_MAPS_API_KEY = "AIzaSyDVjpV022VBbaG2V0QqP0_JZpUrkmnJk0o";

    public function getFunctions()
    {
        return array(
            'globalGoogleMapsApiKey' => array($this, 'globalGoogleMapsApiKey')
        );
    }

    public function globalGoogleMapsApiKey()
    {
        return self::GLOBAL_GOOGLE_MAPS_API_KEY;
    }
}