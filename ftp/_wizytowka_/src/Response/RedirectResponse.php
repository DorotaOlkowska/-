<?php

namespace App\Response;

class RedirectResponse extends Response
{
    public function __construct($resource, array $parameters = array())
    {
        parent::__construct(null, array());

        $this->addHeader(sprintf('Location: %s', $resource));
        $this->setCode('304');
    }
}