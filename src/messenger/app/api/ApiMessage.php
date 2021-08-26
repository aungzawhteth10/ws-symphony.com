<?php
namespace messenger\api;
class ApiMessage extends ApiBase
{
    public function init($request, $response)
    {
        $message_id = $this->session['message_id'];
        $user_id    = $this->session['user_id'];
        $contact_id = $this->session['contact_id'];
        $is_typing = $_GET['isTyping'];
        $cache_file_path = getcwd() . '/src/messenger/app/files/cache/cache.json';
        $cache = json_decode(file_get_contents($cache_file_path), TRUE);
        $new_message_file_path = getcwd() . '/src/messenger/app/files/messages/' . $message_id . '.json';
        $messageData = json_decode(file_get_contents($new_message_file_path), TRUE);
        if (isset($cache['contactTable'])) {
            $contactTable = $cache['contactTable'];
        } else {
            $contactTable = $this->tablesData->getContactTable();
            $cache['contactTable'] = $contactTable;
        }
        $contactTableByUserId = array_column($contactTable, null, 'user_id');
        $contactAccessTime = $contactTableByUserId[$contact_id]['access_time'];
        $contactIsTyping   = $contactTableByUserId[$contact_id]['is_typing'];
        $timeNow = time();
        $contactTableByUserId[$user_id]['access_time'] = $timeNow;
        $contactTableByUserId[$user_id]['is_typing']   = $is_typing;
        $cache['contactTable'] = array_values($contactTableByUserId);
        $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
        file_put_contents($cache_file_path, $json_data);
        $time_diff = $timeNow - (int)$contactAccessTime;
        $result = [];
        $result['active_condition'] = ($time_diff <= 10) ? '<span style="color:green; font-size:200%">●</span>' : '<span style="color:grey; font-size:200%">●</span>';
        error_log(print_r($result, true));
        $messagesNosArr = array_column($messageData, 'message_no');
        rsort($messagesNosArr);
        $result['largest_message_no'] = $messagesNosArr[0] ?? 0;
        $result['is_typing'] = $contactIsTyping;
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
   public function getMessages()
   {
        $user_id    = $this->session['user_id'];
        $contact_id = $this->session['contact_id'];
        $cache_file_path = getcwd() . '/src/messenger/app/files/cache/cache.json';
        $cache = json_decode(file_get_contents($cache_file_path), TRUE);
        if (isset($cache['messageMemberTable'])) {
            $messageMemberTable = $cache['messageMemberTable'];
        } else {
            $messageMemberTable = $this->tablesData->getMessageMemberTable();
            $cache['messageMemberTable'] = $messageMemberTable;
        }
        // if (isset($cache['messagesTable'])) {
        //     $messagesTable = $cache['messagesTable'];
        // } else {
        //     $messagesTable = $this->tablesData->getMessagesTable();
        //     $cache['messagesTable'] = $messagesTable;
        // }
        $messageMember = [$user_id, $contact_id];
        asort($messageMember);
        $messageMember = join('#', $messageMember);
        $messageMemberTableByMember = array_column($messageMemberTable, null, 'message_member');
        $messageMemberTableById = array_column($messageMemberTable, null, 'message_id');
        $messagesIdsArr = array_keys($messageMemberTableById);
        if (!isset($messageMemberTableByMember[$messageMember])) {
            if (count($messagesIdsArr) == 0) {
                $message_id = 1;
            } else {
                rsort($messagesIdsArr);
                $message_id = $messagesIdsArr[0] + 1;
            }
            $new_message_file_path = getcwd() . '/src/messenger/app/files/messages/' . $message_id . '.json';
            $json_data = json_encode([], JSON_UNESCAPED_UNICODE);
            file_put_contents($new_message_file_path, $json_data);
            $cache['messageMemberTable'][] = [
                'message_id'     => $message_id,
                'message_member' => $messageMember,
            ];
            $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
            file_put_contents($cache_file_path, $json_data);
            $_SESSION['message_id'] = $message_id;
            return [];
        }
        $message_id = $messageMemberTableByMember[$messageMember]['message_id'];
        $_SESSION['message_id'] = $message_id;
        $message_file_path = getcwd() . '/src/messenger/app/files/messages/' . $message_id . '.json';
        $messages_info = json_decode(file_get_contents($message_file_path), TRUE);
        $messages = [];
        foreach ($messages_info as $key => $value) {
            $mes = $value['message'];
            $mes = preg_replace("/\r|\n/", "", $mes);
            $message = [
                'message_no' => $value['message_no'],
                'user_id'    => $value['user_id'],
                'message'    => $value['message'],
                'height'     => 30 * ceil(strlen($mes) / 65),
                'pos'        => ($value['user_id'] == $this->session['user_id']) ? 'message_right' : 'message_left',
            ];
            $messages[] = $message;
        }
        error_log(print_r($this->session['user_id'], true));
        return $messages;
    }
    public function sendMessage($request, $response) {
        $largest_message_no = (int)$_POST['largest_message_no'];
        $message            = $_POST['message'];
        $message_id         = $this->session['message_id'];
        $user_id            = $this->session['user_id'];
        $message_file_path = getcwd() . '/src/messenger/app/files/messages/' . $message_id . '.json';
        $messageArr = json_decode(file_get_contents($message_file_path), TRUE);
        error_log(print_r($message_file_path, true));
        $messageArr[] = [
            'message_no' => $largest_message_no + 1,
            'user_id'    => $user_id,
            'message'    => $message,
        ];
        $json_data = json_encode($messageArr, JSON_UNESCAPED_UNICODE);
        file_put_contents($message_file_path, $json_data);
        return json_encode([], JSON_UNESCAPED_UNICODE);
    }
}
