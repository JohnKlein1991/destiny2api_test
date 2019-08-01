<?php
interface IFileAPI
{
    public function readFromFile();

    public function writeToFile($user, $result);
}
