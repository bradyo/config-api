<?php
require_once(__DIR__ . '/../bootstrap.php');

$app = new \Developers\Application(false);
$app->handleRequest();
