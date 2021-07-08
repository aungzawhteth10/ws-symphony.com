<?php
$app->get('/', function ($request, $response) {
    return $view->render($response, 'index.twig', []);
});
