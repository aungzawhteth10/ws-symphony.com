<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
date_default_timezone_set('Asia/Tokyo');
$app = new \Slim\App([
'settings' => [
       'displayErrorDetails' => true,
]
]);
$container = $app->getContainer();
