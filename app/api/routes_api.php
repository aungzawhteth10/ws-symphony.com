<?php
// $app->post('/Api/ApiDeployTest/post', 'ApiDeployTest:post');
$app->post('/Api/ApiDeployTest/post', function () {return 'PostSuccessful';});
