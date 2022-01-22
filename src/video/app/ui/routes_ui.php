<?php
$app->get('/video', function ($request, $response) {
    error_log(print_r(strtolower($_SERVER['HTTP_USER_AGENT']), true));
    return $this->viewVideo->render($response, 'index.twig', []);
});
$app->get('/{id}/', function ($request, $response, $args) {
    return redirect('/' . $args['id']);
});
$app->get('/', function ($request, $response, $args) {
    return redirect('/video');
});
$app->get('/video/{id}/', function ($request, $response, $args) {
    return redirect('/video/' . $args['id']);
});
$app->get('/video/{id}', function ($request, $response, $args) {
    return $this->viewVideo->render($response, 'video.twig', []);
});
/*
 * リダイレクトする
 * @param  String リダイレクトするURL
 * @return String リダイレクトスクリプト
 */
function redirect ($url, $token = '') 
{
    return '<script>location.href= "'. $url . '"</script>';
}
