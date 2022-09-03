<?php

namespace App\Controller;

use App\Response\ErrorResponse;
use App\Response\RedirectResponse;

class ErrorController extends IndexController
{
    public function indexAction()
    {
        if($this->isDisabled())
        {
            return new RedirectResponse('/');
        }

        return new ErrorResponse();
    }
}