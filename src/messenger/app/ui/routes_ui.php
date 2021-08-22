<?php
$app->get('/messenger', function ($request, $response) {
    $token = $_GET['token'] ?? 'zzz';
    return redirect('/messenger/Home', $token);
});
$app->get('/messenger/', function ($request, $response) {
    return redirect('/messenger');
});
$app->get('/messenger/{id}', function ($request, $response, $args) {
    $token = $_GET['token'] ?? 'zzz';
    return _screenInit($args['id'], $token, $this->viewMessenger, $response);
});
/*
 *画面の初期化
 */
function _screenInit ($screenId, $token, $view, $response)
{
    $tablesData = new \messenger\common\TablesData;
    if (in_array($screenId, ['Login', 'login'])) {//ログイン画面の場合
        return _pageMove($view, $response, 'Login');
    }
    $cache_file_path = getcwd() . '\src\messenger\app\files\cache\cache.json';
    $cache = json_decode(file_get_contents($cache_file_path), TRUE);
    if (isset($cache['loginTable'])) {
        $loginTable = $cache['loginTable'];
    } else {
        $loginTable = $tablesData->getLoginTable();
        $cache['loginTable'] = $loginTable;
        $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
        file_put_contents($cache_file_path, $json_data);
    }
    $loginTableByUserId = array_column($loginTable, null, 'user_id');
    error_log(print_r($_SESSION, true));
    if (!isset($_SESSION['user_id'])) {
        return redirect('/messenger/Login');
    }
    $user_id = $_SESSION['user_id'];
    $loginUser = isset($loginTableByUserId[$user_id]) ? $loginTableByUserId[$user_id] : [];
    if (count($loginUser) == 0) {
        return false;
    }
    if ($loginUser['token'] != $token) {
        return redirect('/messenger/Login');
    }
    $timeLimit = $loginUser['time_limit'];
    $timeNow = date('Y-m-d H:i:s');
    $kigen_gire = false;//false：期限切れではない
    if ($timeNow > $timeLimit) {//期限切れ
        return redirect('/messenger/Login');
    }
    error_log(print_r($loginUser['token'], true));
    if (in_array($screenId, ['Message', 'message'])) {//ログイン画面の場合
        $contact_id = $_SESSION['contact_id'];
        $contactUser = isset($loginTableByUserId[$contact_id]) ? $loginTableByUserId[$contact_id] : [];
        $contact_name = count($contactUser) != 0 ? $contactUser['user_name'] : 'ContactName not found';
        $apiMessage = new \messenger\api\ApiMessage;
        $messages = $apiMessage->getMessages();
        $messageNosArr = array_column($messages, 'message_no');
        rsort($messageNosArr);
        return _pageMove ($view, $response, 'Message', ['contact_name' => $contact_name, 'messages' => $messages, 'largest_message_no' => $messageNosArr[0] ?? 0]);
    }
    $sessionArr = $_SESSION;
    // return $sessionArr;
    error_log(print_r($sessionArr, true));
    $view->offsetSet('HtmlHelper', new \messenger\api\HtmlHelper);
    $view->offsetSet('session', json_encode($sessionArr, JSON_UNESCAPED_UNICODE));
    return $view->render($response, $screenId . '.twig', $sessionArr);
}

function _pageMove ($view, $response, $screenId, $screenDataArr = [])
{    
    $sessionArr = $_SESSION;
    $dataArr = [];
    $dataArr = $sessionArr;
    if (count($screenDataArr) != 0) {
        $dataArr = array_merge($dataArr, $screenDataArr);
    }
    error_log(print_r($dataArr, true));
    $view->offsetSet('HtmlHelper', new \messenger\api\HtmlHelper);
    $view->offsetSet('session', json_encode($sessionArr, JSON_UNESCAPED_UNICODE));
    return $view->render($response, $screenId . '.twig', $dataArr);
}
