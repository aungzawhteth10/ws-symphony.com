<?php
$app->post('/Api/ApiSession/update', 'ApiSession:update');
$app->post('/Api/ApiLogin/loginAuth', 'ApiLogin:loginAuth');
$app->post('/Api/ApiLogin/register', 'ApiLogin:register');
$app->post('/Api/ApiBookRegister/register', 'ApiBookRegister:register');
$app->get('/Api/ApiBookManage', 'ApiBookManage:init');
$app->get('/Api/ApiBookInfo', 'ApiBookInfo:init');
$app->post('/Api/ApiBookInfo', 'ApiBookInfo:update');
