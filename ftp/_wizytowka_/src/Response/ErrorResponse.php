<?php

namespace App\Response;

class ErrorResponse extends Response
{
    public function __construct(array $parameters = array())
    {
        parent::__construct('../error.phtml', $parameters);
    }
}