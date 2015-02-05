<?php
require_once(dirname(__DIR__) . '/bootstrap.php');

$config = require(dirname(__DIR__) . '/configs/config.php');
$app = new \Api\Application($config);
$app->handleRequest();
