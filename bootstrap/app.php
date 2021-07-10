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
$container['view'] = function ($container) {
   $view = new \Slim\Views\Twig(__DIR__ . '/../app/templates/', [
       'cache' => false,
   ]);
   $view->addExtension(new \Slim\Views\TwigExtension(
       $container->router,
       $container->request->getUri()
   ));
   return $view;
};
$container['ApiDeployTest'] = function () {
   return new \App\Api\ApiDeployTest;
};
