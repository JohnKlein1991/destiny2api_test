<?php
const ROOT = __DIR__;
require_once ROOT . '/autoload.php';

$config = require ROOT . '/config/config.php';
$configLocal = require ROOT . '/config/config_local.php';
$configFile = require ROOT . '/config/config_file.php';

$itemId = '3260604717';

$api = new Destiny2API(array_merge($config, $configLocal));
$fapi = new FileApi($configFile);
$usersList = $fapi->readFromFile();
if(!$usersList) exit();

foreach ($usersList as $user){
    try {
        $result = $api->checkHasItem($user, $itemId);
        $fapi->writeToFile($user, $result);
    } catch (Exception $e) {
        continue;
    }
}