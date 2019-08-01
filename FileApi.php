<?php
class FileApi implements IFileAPI
{
    private $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function readFromFile()
    {
        $result = [];
        $file = fopen(__DIR__ .'/'. $this->config['inputFileName'], 'r');
        while ($line = fgets($file)){
            $result[] = trim($line);
        }
        return $result;
    }
    public function writeToFile($user, $result)
    {
        $file = fopen(__DIR__ .'/'. $this->config['outputFileName'], 'a');
        fwrite($file, "$user - $result".PHP_EOL);
    }
}