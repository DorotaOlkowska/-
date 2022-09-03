<?php

namespace App\EventManager;

use App\Factory\Factory;

class EventManager
{
    public $listeners = array();

    public function addListener($eventName, $listener)
    {
        $this->listeners[$eventName] = $listener;

        return $this;
    }

    public function addSubscriber(SubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $listener) {
            $this->addListener($eventName, $listener);
        }

        return $this;
    }

    public function hasEvent($eventName)
    {
        return isset($this->listeners[$eventName]);
    }

    public function dispatch($eventName, Context &$context)
    {
        if (!$this->hasEvent($eventName)) {
            throw new \Exception(sprintf('Event "%s" does not have listener', $eventName));
        }

        $listener = $this->getListenerStructure($this->listeners[$eventName]);

        if (!is_object($listener->instance)) {
            $object = Factory::getInstance($listener->instance, array($context));
        } else {
            $object = $listener->instance;
        }

        $method = $listener->method;
        $parameters = $context->getParameters();

        $code = 'return call_user_func(array($object, $method),';
        foreach ($parameters as $id => $parameter) {
            $code .= sprintf('$parameters[%s],', $id);
        }
        $code = rtrim($code, ',');
        $code .= ');';
        $results = eval($code);
        $context->setResults($results);
    }

    private function getListenerStructure($listener)
    {
        return (object)array(
            'instance' => $listener[0],
            'method' => $listener[1]
        );
    }
}
