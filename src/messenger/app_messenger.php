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
//Database Object
$dsn = 'mysql:dbname=u460610115_messenger;host=sql255.main-hosting.eu';
$username = 'u460610115_messenger_root';
$password = 'Toorwss9199';
try {
    $_SESSION['MessengerPdo'] = new \PDO($dsn, $username, $password);
} catch (\PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

