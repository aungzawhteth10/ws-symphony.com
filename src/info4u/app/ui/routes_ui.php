<?php
$app->get('/info4u/', function ($request, $response) {
    return $this->viewInfo4u->render($response, 'index.twig', []);
});
$app->get('/info4u', function ($request, $response) {
    return '<script>location.href= "/info4u/"</script>';
});

$app->get('/info4u/{id}', function ($request, $response, $args) {
    return $this->viewInfo4u->render($response, $args['id'] . '.twig', []);
});
