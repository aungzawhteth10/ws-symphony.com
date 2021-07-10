<?php
$app->get('/', function ($request, $response) {
    return $this->view->render($response, 'index.twig', []);
});
$app->get('/{id}', function ($request, $response, $args) {
    return $this->view->render($response, $args['id'] . '.twig', []);
});
