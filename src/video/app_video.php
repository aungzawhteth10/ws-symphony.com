<?php
$container['viewVideo'] = function ($container) {
   $viewVideo = new \Slim\Views\Twig(__DIR__ . '/app/templates/', [
       'cache' => false,
   ]);
   $viewVideo->addExtension(new \Slim\Views\TwigExtension(
       $container->router,
       $container->request->getUri()
   ));
   return $viewVideo;
};
$container['ApiDeployTest'] = function () {
    return new \video\api\ApiDeployTest;
};
