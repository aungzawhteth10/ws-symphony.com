<?php
$app->get('/video', function ($request, $response) {
    error_log(print_r(strtolower($_SERVER['HTTP_USER_AGENT']), true));
    return $this->viewVideo->render($response, 'index.twig', []);
});
$app->get('/{id}/', function ($request, $response, $args) {
    return redirect('/' . $args['id']);
});
$app->get('/video/{id}', function ($request, $response, $args) {
    if ($args['id'] == 'o2_division') renderO2Division(); 
    return $this->viewVideo->render($response, $args['id'] . '.twig', []);
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
/*
 * o2_division 画面の情報を返す
 * @return ResponseInterface o2_division 画面の情報
 */
function renderO2Division () 
{
    return '<script>location.href= "'. $url . '"</script>';
}

