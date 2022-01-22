<?php
require __DIR__ . '/bootstrap/app.php';
//info4u
// require __DIR__ . '/src/info4u/app_info4u.php';
// require __DIR__ . '/src/info4u/app/ui/routes_ui.php';
// require __DIR__ . '/src/info4u/app/api/routes_api.php';
//messenger
// require __DIR__ . '/src/messenger/app_messenger.php';
// require __DIR__ . '/src/messenger/app/ui/routes_ui.php';
// require __DIR__ . '/src/messenger/app/api/routes_api.php';
//video
require __DIR__ . '/src/video/app_video.php';
require __DIR__ . '/src/video/app/ui/routes_ui.php';
require __DIR__ . '/src/video/app/api/routes_api.php';

$app->run();
