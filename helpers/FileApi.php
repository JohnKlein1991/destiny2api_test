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
        $filePath = ROOT . $this->config['inputFile'];
        if (!is_file($filePath)){
            return false;
        }
        $file = fopen($filePath, 'r');
        while ($line = fgets($file)){
            $result[] = trim($line);
        }
        return $result;
    }
    public function writeToFile($user, $result)
    {
        $filePath = ROOT . $this->config['outputFile'];
        $file = fopen($filePath, 'a');
        fwrite($file, "$user - $result".PHP_EOL);
    }
}