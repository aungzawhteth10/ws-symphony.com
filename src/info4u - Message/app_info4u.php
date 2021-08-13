<?php
$container['viewInfo4u'] = function ($container) {
   $viewInfo4u = new \Slim\Views\Twig(__DIR__ . '/app/templates/', [
       'cache' => false,
   ]);
   $viewInfo4u->addExtension(new \Slim\Views\TwigExtension(
       $container->router,
       $container->request->getUri()
   ));
   return $viewInfo4u;
};
$container['ApiDeployTest'] = function () {
    return new \info4u\api\ApiDeployTest;
};
