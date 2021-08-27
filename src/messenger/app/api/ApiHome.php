<?php
namespace messenger\api;
class ApiHome extends ApiBase
{
   public function init($request, $response)
   {
        $user_id = $this->session['user_id'];
        $cache_file_path = getcwd() . '/src/messenger/app/files/cache/cache.json';
        $cache = json_decode(file_get_contents($cache_file_path), TRUE);
        if (isset($cache['loginTable'])) {
            $loginTable = $cache['loginTable'];
        } else {
            $loginTable = $this->tablesData->getLoginTable();
            $cache['loginTable'] = $loginTable;
        }
        if (isset($cache['contactTable'])) {
            $contactTable = $cache['contactTable'];
        } else {
            $contactTable = $this->tablesData->getContactTable();
            $cache['contactTable'] = $contactTable;
        }
        error_log(print_r($cache, true));
        $contactTableByUserId = array_column($contactTable, null, 'user_id');
        if (!isset($contactTableByUserId[$user_id])) {
            return false;
        }
        $contacts = $contactTableByUserId[$user_id]['contacts'];
        $contacts = explode('#', $contacts);
        if (count($contacts) == 0) {
            return false;
        }
        $timeNow = time();
        $contactTableByUserId[$user_id]['access_time'] = $timeNow;
        $cache['contactTable'] = array_values($contactTableByUserId);
        $result = [];
        $loginTableByUserId = array_column($loginTable, null, 'user_id');
        foreach ($contacts as $key => $contact_id) {
            if (!isset($loginTableByUserId[$contact_id])) {
                continue;
            }
            $contactInfo = $loginTableByUserId[$contact_id];
            if (count($contactInfo) == 0) {
                continue;
            }
            if (!isset($contactTableByUserId[$contact_id])) {
                continue;
            }
            $contactResult = $contactTableByUserId[$contact_id];
            $contactAccessTime = $contactResult['access_time'];
            $time_diff = $timeNow - (int)$contactAccessTime;
            if ($timeNow - (int)$contactAccessTime <= 5) {
                $result[] = [
                    'contact_id'   => $contact_id,
                    'contact_name' => $contactInfo['user_name'],
                    'contact_name_view' => '<span style="color:green; font-size:200%">●</span><span style="font-size:150%">' . $contactInfo['user_name'] . '</span>',
                    'status'       => 'Online'
                ];
            } else {
                $result[] = [
                    'contact_id'   => $contact_id,
                    'contact_name' => $contactInfo['user_name'],
                    'contact_name_view' => '<span style="color:grey; font-size:200%">●</span><span style="font-size:150%">' . $contactInfo['user_name'] . '</span>',
                    'status'       => 'Offline'
                ];
            }
        }
        $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
        file_put_contents($cache_file_path, $json_data);
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
