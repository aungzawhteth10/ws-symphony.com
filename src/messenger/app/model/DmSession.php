<?php
namespace messenger\model;
class DmSession extends DataModel
{
    public static $schema = [
        'user_id'   => 'string',//ユーザID
        'user_name' => 'string',//ユーザ名
        'id_name'   => 'string',//ユーザID#ユーザ名
    ];
    public function getSessionArr ()
    {
        $data = $this->toArray();
        $data['session'] = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $data;
    }
}