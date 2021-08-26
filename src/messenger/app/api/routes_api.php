<?php
//Session
$app->post('/messenger/api/ApiSession/update', 'MessengerApiSession:update');
//Login
$app->post('/messenger/api/ApiLogin/loginAuth', 'MessengerApiLogin:loginAuth');
$app->post('/messenger/api/ApiDeployTest/post', function () {return 'PostSuccessful';});
//Home
$app->get('/messenger/api/ApiHome', 'MessengerApiHome:init');
//Message
$app->post('/messenger/api/ApiMessage/sendMessage', 'MessengerApiMessage:sendMessage');
$app->get('/messenger/api/ApiMessage', 'MessengerApiMessage:init');