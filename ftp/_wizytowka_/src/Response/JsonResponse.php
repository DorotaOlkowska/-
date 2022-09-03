<?php

namespace App\Response;


class JsonResponse extends Response
{
    public function __construct(array $parameters = array())
    {
        parent::__construct('../json.phtml', array('json' => json_encode($parameters)));
        $this->addHeader('Content-Type: application/json');
    }
}