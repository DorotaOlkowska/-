<?php

namespace App\Service\BusinessCard\Datasource;

class File
{
    private $dataSourceFile;

    /**
     * Application_Datasource_File constructor.
     * @param $dataSourceFile
     */
    public function __construct($dataSourceFile)
    {
        $this->setupDataSourceFileName($dataSourceFile);
    }

    /**
     * @param $string
     * @throws \Exception
     */
    public function save($string)
    {
        $this->throwExceptionIfFileIsNotWritable();
        $fileOpenResource = fopen($this->dataSourceFile, "w");
        flock($fileOpenResource, LOCK_EX);
        fwrite($fileOpenResource, $string);
        flock($fileOpenResource, LOCK_UN);
        fclose($fileOpenResource);
    }

    /**s
     * @return bool|string
     * @throws \Exception
     */
    public function get()
    {
        $this->throwExceptionIfFileIsNotReadable();
        $fileOpenResource = fopen($this->dataSourceFile, "r");
        flock($fileOpenResource, LOCK_SH);
        $contents = fread($fileOpenResource, filesize($this->dataSourceFile));
        flock($fileOpenResource, LOCK_UN);
        fclose($fileOpenResource);

        return $contents;
    }

    private function setupDataSourceFileName($dataSourceFile)
    {
        $this->throwExceptionIfFileNotExits($dataSourceFile);
        $this->dataSourceFile = $dataSourceFile;
    }

    /**
     * @throws \Exception
     */
    private function throwExceptionIfFileNotExits($dataSourceFile)
    {
        if(!file_exists($dataSourceFile)){
            throw new \Exception($dataSourceFile . ' do not exists');
        }
    }

    /**
     * @throws \Exception
     */
    private function throwExceptionIfFileIsNotReadable()
    {
        if(!is_readable($this->dataSourceFile)){
            throw new \Exception($this->dataSourceFile . ' do not readable');
        }
    }

    /**
     * @throws \Exception
     */
    private function throwExceptionIfFileIsNotWritable()
    {
        if(!is_writable($this->dataSourceFile)){
            throw new \Exception($this->dataSourceFile . ' is not writable');
        }
    }
}