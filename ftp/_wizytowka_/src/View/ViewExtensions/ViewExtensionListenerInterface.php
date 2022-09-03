<?php

namespace App\View\ViewExtensions;

use App\EventManager\SubscriberInterface;

interface ViewExtensionSubscriberInterface extends SubscriberInterface
{
    public function getFunctions();
}