<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/ICheckHasItem.php';
require_once __DIR__ . '/IFileAPI.php';
require_once __DIR__ . '/Destiny2API.php';
require_once __DIR__ . '/FileApi.php';

$config = require __DIR__ . '/config.php';
$configLocal = require __DIR__ . '/config_local.php';
$configFile = require __DIR__ . '/config_file.php';

$itemId = '3260604717';

$api = new Destiny2API(array_merge($config, $configLocal));
$fapi = new FileApi($configFile);
$usersList = $fapi->readFromFile();
foreach ($usersList as $user){
    try {
        $result = $api->checkHasItem($user, $itemId);
        $fapi->writeToFile($user, $result);
    } catch (Exception $e) {
        continue;
    }
}