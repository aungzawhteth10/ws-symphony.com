<?php
namespace messenger\api;
class ApiLogin extends ApiBase
{
   public function loginAuth($request, $response)
   {
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $dbLoginMapper = new \messenger\db\DbLoginMapper;
        $dmLogin = new \messenger\model\DmLogin;
        $dmLogin->user_name = $user_name;
        $dmLogin->password  = $password;
        $loginUser = $dbLoginMapper->find($dmLogin);
        if (count($loginUser) == 0) {
            return false;
        }
        $token = $this->createToken($loginUser[0]['user_id']);
        $result = [
            'token' => $token,
        ];
        $_SESSION['user_id']   = $loginUser[0]['user_id'];
        $_SESSION['user_name'] = $loginUser[0]['user_name'];
        $_SESSION['id_name']   = join('#', [$loginUser[0]['user_id'], $loginUser[0]['user_name']]);
        return json_encode($result, JSON_UNESCAPED_UNICODE);
   }
   public function register($request, $response)
   {
        $user_name   = $_POST['reg_user_name'];
        $password    = $_POST['reg_password'];
        $dbUserMapper = new \messenger\db\DbUserMapper;
        $dmUser = new \messenger\model\DmUser;
        $dmUser->user_name = $user_name;
        $dmUser->password  = $password;
        $count = $dbUserMapper->insert($dmUser);
        $user = $dbUserMapper->find($dmUser);
        $token = $this->createToken($user[0]['user_id']);
        $result = [
            'token' => $token,
        ];
        return json_encode($result, JSON_UNESCAPED_UNICODE);
   }
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
        $dbLoginMapper = new \messenger\db\DbLoginMapper;
        $dmLogin = new \messenger\model\DmLogin;
        $dmLogin->user_id = $user_id;
        $dmLogin->token   = $token;
        $dmLogin->time_limit = $time_limit;
        $loginUser = $dbLoginMapper->update($dmLogin);
        return $token;
   }
}
