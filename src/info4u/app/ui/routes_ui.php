<?php
$app->get('/info4u/', function ($request, $response) {
    return $this->viewInfo4u->render($response, 'index.twig', []);
});
$app->get('/', function ($request, $response) {
    return redirect('/info4u/');
});
$app->get('/info4u', function ($request, $response) {
    return redirect('/info4u/');
});
$app->get('/info4u/{id}', function ($request, $response, $args) {
    if ($args['id'] == 'o2_division') renderO2Division(); 
    return $this->viewInfo4u->render($response, $args['id'] . '.twig', []);
});
/*
 * リダイレクトする
 * @param  String リダイレクトするURL
 * @return String リダイレクトスクリプト
 */
function redirect ($url, $token = '') 
{
    return '<script>location.href= "'. $url . '?token=' . $token . '"</script>';
}
/*
 * o2_division 画面の情報を返す
 * @return ResponseInterface o2_division 画面の情報
 */
function renderO2Division () 
{
    return '<script>location.href= "'. $url . '"</script>';
}

