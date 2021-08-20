<?php
$app->get('/messenger', function ($request, $response) {
    $token = $_GET['token'] ?? 'zzz';
    return redirect('/messenger/Home', $token);
});
// $app->get('/messenger', function ($request, $response) {
//     return redirect('/messenger/');
// });
$app->get('/messenger/{id}', function ($request, $response, $args) {
    $token = $_GET['token'] ?? 'zzz';
    return _screenInit($args['id'], $token, $this->viewMessenger, $response);
});
/*
 *画面の初期化
 */
function _screenInit ($screenId, $token, $view, $response)
{
    if (in_array($screenId, ['Login', 'login'])) {//ログイン画面の場合
        $sessionArr = $_SESSION;
        $view->offsetSet('session', json_encode($sessionArr, JSON_UNESCAPED_UNICODE));
        return $view->render($response, 'Login.twig', $sessionArr);
    }
    $cache_file_path = getcwd() . '\src\messenger\app\files\cache\cache.json';
    $cache = json_decode(file_get_contents($cache_file_path), TRUE);
    if (isset($cache['loginTable'])) {
        $loginTable = $cache['loginTable'];
    } else {
        $loginTable = $this->tablesData->getLoginTable();
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
    error_log(print_r($user_id, true));
    error_log(print_r($loginTableByUserId, true));
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
    $sessionArr = $_SESSION;
    // return $sessionArr;
    error_log(print_r($sessionArr, true));
    $view->offsetSet('HtmlHelper', new \messenger\api\HtmlHelper);
    $view->offsetSet('session', json_encode($sessionArr, JSON_UNESCAPED_UNICODE));
    return $view->render($response, $screenId . '.twig', $sessionArr);
}
/*
 * Login画面へ遷移する
 */
function _toLoginPage ()
{
    $url = '/Login';
    $script = '<script>location.href="' . $url .'"</script>';
    return $script;
}
/*
 * セッション情報を生成する
 */
function _createSessionInfo ($screenId)
{
    $dbKinouMapper = new \messenger\db\DbKinouMapper;
    $dmKinou = new \messenger\Model\DmKinou;
    $dmKinou->screen_id = $screenId;
    $kinou = $dbKinouMapper->find($dmKinou);
    $dmSession = new \messenger\model\DmSession;
    $dmSession->screen_name = (isset($kinou[0])) ? $kinou[0]['name'] : "未登録";
    $result = $dmSession->toArray();
    $_SESSION['screen_name'] = $dmSession->screen_name;
}
