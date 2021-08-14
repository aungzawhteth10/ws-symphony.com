<?php
namespace messenger\api;
class ApiHome extends ApiBase
{
   public function init($request, $response)
   {
        $user_id = $this->session['user_id'];
        $dbContactMapper = new \messenger\db\DbContactMapper;
        $dmContact = new \messenger\model\DmContact;
        $dmContact->user_id = $user_id;
        $contactUserResult = $dbContactMapper->find($dmContact);
        if (count($contactUserResult) == 0) {
            return false;
        }
        $contacts = explode('#', $contactUserResult[0]['contacts']);
        error_log(print_r('user_id', true));
        error_log(print_r(gettype($contactUserResult[0]['user_id']), true));
        if (count($contacts) == 0) {
            return false;
        }
        $timeNow = time();
        $dmContact->access_time = $timeNow;
        $count = $dbContactMapper->update($dmContact);
        $dmContact = new \messenger\model\DmContact;
        $result = [];
        foreach ($contacts as $key => $contact_id) {
            $dbLoginMapper = new \messenger\db\DbLoginMapper;
            $dmLogin = new \messenger\model\DmLogin;
            $dmLogin->user_id = $contact_id;
            $contactInfo = $dbLoginMapper->find($dmLogin);
            if (count($contactInfo) == 0) {
                continue;
            }
            $dmContact->user_id = $contact_id;
            $contactResult = $dbContactMapper->find($dmContact);
            $contactAccessTime = $contactResult[0]['access_time'];
            $time_diff = $timeNow - (int)$contactAccessTime;
            if ($timeNow - (int)$contactAccessTime <= 10) {
                $result[] = [
                    'contact_id'   => $contact_id,
                    'contact_name' => '<span style="color:green; font-size:200%">●</span><span style="font-size:150%">' . $contactInfo[0]['user_name'] . '</span>',
                    'status'       => 'Online'
                ];
            } else {
                $result[] = [
                    'contact_id'   => $contact_id,
                    'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">' . $contactInfo[0]['user_name'] . '</span>',
                    'status'       => 'Offline'
                ];
            }
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
        // error_log(print_r($timeNow, true));
        // $result = [
        //     'token' => $token,
        // ];
        // $_SESSION['user_id']   = $loginUser[0]['user_id'];
        // $_SESSION['user_name'] = $loginUser[0]['user_name'];
        // $_SESSION['id_name']   = join('#', [$loginUser[0]['user_id'], $loginUser[0]['user_name']]);
        $result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:green; font-size:200%">●</span><span style="font-size:150%">AZH</span>',
            'status'       => 'Online'
        ];
        $result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];
        $result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];$result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];$result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];$result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];$result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];$result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];$result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Offline'
        ];
        $result[] = [
            'contact_id'   => 1,
            'contact_name' => '<span style="color:green; font-size:200%">●</span><span style="font-size:150%">NRT</span>',
            'status'       => 'Online'
        ];
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
