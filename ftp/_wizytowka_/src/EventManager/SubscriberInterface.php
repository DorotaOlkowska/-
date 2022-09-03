<?php

namespace App\EventManager;

use App\Service\ServiceContainer\ServiceContainer;

interface SubscriberInterface
{
    public function __construct(array $subscribedEvents);

    public function getSubscribedEvents();
}