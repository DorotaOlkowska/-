<?php

namespace App\Service\HttpAuth;

use App\Response\Response;
use App\Service\Logger\Logger;
use App\Service\Logger\LoggerLevel;
use App\Service\Request\Request;
use App\Service\ServiceInterface;

class HttpAuth implements ServiceInterface
{
    private $username;
    private $password;
    private $request;
    private $logger;

    public function __construct(Request $request, Logger $logger, $authFile)
    {
        $data = explode(':businessCardApi:', file_get_contents($authFile));

        $this->logger = $logger;
        $this->username = $data[0];
        $this->password = $data[1];

        if(preg_match('/\s/', substr($this->password, -1, 1)))
        {
            $this->password = substr($this->password, 0, -1);
        }

        $this->request = $request;
    }

    /**
     * @return bool
     * @throws \App\Service\Logger\LoggerException
     */
    public function hasAccess()
    {
        if(($this->request->getServer('PHP_AUTH_USER') == $this->username &&
            $this->request->getServer('PHP_AUTH_PW') == $this->password))
        {
            return true;
        }

        $this->logger->log(sprintf('User unsuccessful trying to login by %s %s', $this->username, $this->getHashedPassword()), LoggerLevel::WARN);

        return false;
    }

    public function getAuthResponse()
    {
        $response = new Response();
        $response->addHeader('WWW-Authenticate: Basic realm="My Realm"');
        $response->addHeader('HTTP/1.0 401 Unauthorized');
        $response->setCode(401);

        return $response;
    }

    private function getHashedPassword()
    {
        return preg_replace('/./', '*', $this->request->getServer('PHP_AUTH_PW'));
    }
}