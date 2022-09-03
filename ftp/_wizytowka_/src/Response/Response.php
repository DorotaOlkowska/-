<?php

namespace App\Response;

class Response
{
    protected $contents;
    protected $code = 200;
    protected $headers = array();
    protected $resource = null;
    protected $parameters;

    /**
     * Response constructor.
     * @param $resource
     * @param array $parameters
     */
    public function __construct($resource = null, array $parameters = array())
    {
        $this->resource = $resource;
        $this->parameters = $parameters;
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;

        return $this;
    }

    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function send()
    {
        if ($this->headers && !headers_sent()) {
            foreach ($this->headers as $header) {
                header($header);
            }
        } else {
            if (function_exists('http_response_code')) {
                http_response_code($this->code);
            } else {
                header("HTTP/1.1 200 OK");
            }
        }

        echo $this->contents;
    }

    public function hasResource()
    {
        return !empty($this->resource);
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}