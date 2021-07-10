<?php
$app->get('/', function ($request, $response) {
    return 'ws-symphony';
    return $this->view->render($response, 'index.twig', []);
});
$app->get('/aaa', function ($request, $response, $args) {
    return 'get AAA';
});
// $app->get('/{id}', function ($request, $response, $args) {
//     return $this->view->render($response, $args['id'] . '.twig', []);
// });
