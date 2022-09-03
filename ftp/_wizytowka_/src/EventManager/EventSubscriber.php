<?php

namespace App\EventManager;

class EventSubscriber implements SubscriberInterface
{
    protected $subscribedEvents;

    public function __construct(array $subscribedEvents)
    {
        $this->subscribedEvents = $subscribedEvents;
    }

    public function getSubscribedEvents()
    {
        return $this->subscribedEvents;
    }
}