<?php
$container['viewMessenger'] = function ($container) {
   $viewMessenger = new \Slim\Views\Twig(__DIR__ . '/app/templates/', [
       'cache' => false,
   ]);
   $viewMessenger->addExtension(new \Slim\Views\TwigExtension(
       $container->router,
       $container->request->getUri()
   ));
   return $viewMessenger;
};
$container['ApiDeployTest'] = function () {
    return new \messenger\api\ApiDeployTest;
};
$container['MessengerApiLogin'] = function () {
    return new \messenger\api\ApiLogin;
};
$container['MessengerApiHome'] = function () {
    return new \messenger\api\ApiHome;
};

