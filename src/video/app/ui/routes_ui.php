<?php
$app->get('/sakura_s9/myanmar_menu', function ($request, $response, $args) {
    return redirect('/sakura_s9/myanmar menu.pdf?' . date('mdHis'));
});
/*$app->get('/video', function ($request, $response) {
    error_log(print_r(strtolower($_SERVER['HTTP_USER_AGENT']), true));
    $video_template = createVideoTamplate();
    return $this->viewVideo->render($response, 'index.twig', ['video_template' => $video_template]);
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
});*/
/*
 * リダイレクトする
 * @param  String リダイレクトするURL
 * @return String リダイレクトスクリプト
 */
function redirect ($url, $token = '') 
{
    return '<script>location.href= "'. $url . '"</script>';
}
function createJson () {
    $cache_file_path = getcwd() . '/src/video/videos/000.json';
    $cache = json_decode(file_get_contents($cache_file_path), TRUE);
    error_log(print_r($cache, true));
    $data = [];
    $cache[] = [
        'id'       => '00001',
        'link'     => 'https://www.almightyboy.com/wp-content/uploads/2021/07/a55.jpg',
        'pic'      => 'https://www.almightyboy.com/wp-content/uploads/2021/07/a55.jpg',
        'name'     => 'Uzumaki Family',
        'duration' => '',
    ];
    $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
    file_put_contents($cache_file_path, $json_data);
}
function createVideoTamplate () {
    $video_file_path = getcwd() . '/src/video/videos/000.json';
    $videos = json_decode(file_get_contents($video_file_path), TRUE);
    $video_template = '';
    foreach ($videos as $key => $value) {
        $video_template .= "<a href='" . $value['link'] . "'><div class='video'><img src='" . $value['pic'] . "' class='pic'></div>" . $value['name'] . "<span class='time'>" . $value['duration'] . "</span>";
    }
    return $video_template;
}
