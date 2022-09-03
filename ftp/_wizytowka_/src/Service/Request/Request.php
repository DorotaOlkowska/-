<?php

namespace App\Service\Request;

use App\Service\ServiceInterface;
use App\Service\Session\Session;

class Request implements ServiceInterface
{
    const REQUEST_METHOD_POST = 'post';

    protected $get;
    protected $post;
    protected $server;
    protected $env;
    protected $session;
    private $input;
    private $requestUri;

    public function __construct(Session $session)
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->env = $_ENV;
        $this->session = $session;
        $this->input = file_get_contents('php://input');
        $this->requestUri = $this->getParsedRequestUri();
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getServer($key)
    {
        return isset($this->server[$key]) ? $this->server[$key] : null;
    }

    public function getEnv($key)
    {
        return isset($this->env[$key]) ? $this->env[$key] : null;
    }

    public function getQuery($key = null, $default = null)
    {
        return $key ? (isset($this->get[$key]) ? $this->get[$key] : $default) : $this->get;
    }

    public function getPost($key = null, $default = null)
    {
        return $key ? (isset($this->post[$key]) ? $this->post[$key] : $default) : $this->post;
    }

    public function isPost()
    {
        return strtolower($this->getServer('REQUEST_METHOD')) === self::REQUEST_METHOD_POST;
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }

    public function getRequestMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    private function getParsedRequestUri()
    {
        $baseDir = $this->getBaseDir();

        if ($baseDir && $baseDir !== '/') {
            return str_replace($baseDir, '/', $this->getServer('REQUEST_URI'));
        } else {
            return $this->getServer('REQUEST_URI') ? $this->getServer('REQUEST_URI') : $baseDir;
        }
    }

    public function isHttps()
    {
        return (bool)$this->getServer('HTTPS');
    }

    public function getBaseUrl()
    {
        return sprintf('%s%s%s', ($this->isHttps() ? 'https://' : 'http://'), $this->getServer('HTTP_HOST'),
            $this->getBaseDir());
    }

    public function getSecureBaseUrl()
    {
        return str_replace('http://', 'https://', $this->getBaseUrl());
    }

    public function getHttpHost()
    {
        $host = $this->getServer('HTTP_HOST');

        if (!empty($host)) {
            return $host;
        }

        $https = $this->isHttps();
        $name = $this->getServer('SERVER_NAME');
        $port = $this->getServer('SERVER_PORT');

        return (!$https && $port == 80) || ($https && $port == 443) ? $name : $name . ':' . $port;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getBaseDir()
    {
        $phpSelfDirName = dirname($this->getServer('PHP_SELF'));
        $phpSelfDirName = preg_replace('/(.*\.php)(.*)/', '$1', $phpSelfDirName);

        return $phpSelfDirName === '/' ? $phpSelfDirName : $phpSelfDirName . '/';
    }

    public function getUserIp()
    {
        $httpClientIp = $this->getServer('HTTP_CLIENT_IP');
        $httpXForwardedFor = $this->getServer('HTTP_X_FORWARDED_FOR');
        $remoteAddr = $this->getServer('REMOTE_ADDR');

        if ($httpClientIp) {
            return $httpClientIp;
        } elseif ($httpXForwardedFor) {
            return $httpXForwardedFor;
        } else {
            return $remoteAddr;
        }
    }
}


