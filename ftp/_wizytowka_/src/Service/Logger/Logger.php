<?php

namespace App\Service\Logger;

use App\Service\Request\Request;
use App\Service\ServiceInterface;

class Logger implements ServiceInterface
{
    const LOGGER_FILE_SUFFIX = '-logs.log';

    private $config;
    private $currentLogger;
    private $request;

    public function __construct($config, Request $request)
    {
        $this->config = $config;
        $this->currentLogger = $config['default'];
        $this->request = $request;
    }

    /**
     * @param $message
     * @param string $level
     * @throws LoggerException
     */
    public function log($message, $level = LoggerLevel::INFO)
    {
        $logger = $this->getLogger();
        $filename = $this->getFilename($logger);
        $this->checkWritable($filename);
        $this->createFileIfNotExists($filename);
        $this->saveToFile(
            $filename,
            sprintf("[%s] %s %s: %s %s", date('Y-m-d-H-i-s'), $this->request->getUserIp(), $level, $message, PHP_EOL),
            FILE_APPEND
        );
    }

    private function getFilename($logger)
    {
        return $logger['dir'] . date('Y-m-d-') . $logger['name'] . self::LOGGER_FILE_SUFFIX;
    }

    public function getLogger()
    {
        return $this->config[$this->currentLogger];
    }

    public function setLogger($logger)
    {
        $this->currentLogger = $logger;

        return $this;
    }

    /**
     * @param $filename
     * @throws LoggerException
     */
    private function checkWritable($filename)
    {
        if (!is_writable(dirname($filename))) {
            throw new LoggerException(sprintf('Directory \'%s\' is not writable', dirname($filename)));
        }
    }

    /**
     * @param $filename
     */
    private function createFileIfNotExists($filename)
    {
        if (!file_exists($filename)) {
            touch($filename);
        }
    }

    private function saveToFile($filename, $message, $flag)
    {
        file_put_contents($filename, $message, $flag);
    }

    /**
     * @param \Exception $e
     * @throws LoggerException
     */
    public function logException(\Exception $e)
    {
        $this->log(sprintf('%s in %s:%s\n %s', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString()),
            LoggerLevel::ERROR);
    }
}