<?php
namespace messenger\api;
class ApiLogin extends ApiBase
{
   public function loginAuth($request, $response)
   {
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $cache_file_path = getcwd() . '/src/messenger/app/files/cache/cache.json';
        $cache = json_decode(file_get_contents($cache_file_path), TRUE);
        error_log(print_r($cache, true));
        if (isset($cache['loginTable'])) {
            $loginTable = $cache['loginTable'];
        } else {
            $loginTable = $this->tablesData->getLoginTable();
            $cache['loginTable'] = $loginTable;
            $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
            file_put_contents($cache_file_path, $json_data);
        }
        $loginTableByUserName = array_column($loginTable, null, 'user_name');
        $loginUser = isset($loginTableByUserName[$user_name]) ? $loginTableByUserName[$user_name] : [];
        if (count($loginUser) == 0) {
            return false;
        }
        if ($loginUser['password'] != $password) {
            return false;
        }
        $token = $this->createToken($loginUser['user_id']);
        $result = [
            'token' => $token,
        ];
        $_SESSION['user_id']   = $loginUser['user_id'];
        $_SESSION['user_name'] = $loginUser['user_name'];
        $_SESSION['id_name']   = join('#', [$loginUser['user_id'], $loginUser['user_name']]);
        $_SESSION['token']     = $token;
        return json_encode($result, JSON_UNESCAPED_UNICODE);
   }
   // public function register($request, $response)
   // {
   //      $user_name   = $_POST['reg_user_name'];
   //      $password    = $_POST['reg_password'];
   //      $dbUserMapper = new \messenger\db\DbUserMapper;
   //      $dmUser = new \messenger\model\DmUser;
   //      $dmUser->user_name = $user_name;
   //      $dmUser->password  = $password;
   //      $count = $dbUserMapper->insert($dmUser);
   //      $user = $dbUserMapper->find($dmUser);
   //      $token = $this->createToken($user[0]['user_id']);
   //      $result = [
   //          'token' => $token,
   //      ];
   //      return json_encode($result, JSON_UNESCAPED_UNICODE);
   // }
   public function createToken($user_id)
   {
        //認証キーを作成する。
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i < 100; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
        //認証キーの有効期間を作成（有効期間：3時間）
        $jikan_24 = time() + (24 * 60 * 60);
        $time_limit = date('Y-m-d H:i:s', $jikan_24);
        $cache_file_path = getcwd() . '/src/messenger/app/files/cache/cache.json';
        $cache = json_decode(file_get_contents($cache_file_path), TRUE);
        if (isset($cache['loginTable'])) {
            $loginTable = $cache['loginTable'];
        } else {
            $loginTable = $this->tablesData->getLoginTable();
            error_log(print_r($cache, true));
        }
        $loginTableByUserId = array_column($loginTable, null,'user_id');
        $loginTableByUserId[$user_id]['token']      = $token;
        $loginTableByUserId[$user_id]['time_limit'] = $time_limit;
        $cache['loginTable'] = array_values($loginTableByUserId);
        $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
        file_put_contents($cache_file_path, $json_data);
        return $token;
   }
}
