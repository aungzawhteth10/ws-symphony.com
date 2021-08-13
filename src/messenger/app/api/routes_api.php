<?php
$app->post('/messenger/api/ApiLogin/loginAuth', 'MessengerApiLogin:loginAuth');
$app->post('/messenger/api/ApiDeployTest/post', function () {return 'PostSuccessful';});
//Home
$app->get('/messenger/api/ApiHome', 'MessengerApiHome:init');

