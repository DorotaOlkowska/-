<?php

namespace App\EventManager;

interface ListenerInterface
{
    public function __construct(Context $context);
}