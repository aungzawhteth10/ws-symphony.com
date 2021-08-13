<?php
namespace messenger\model;
class DmLogin extends DataModel
{
    public static $schema = [
        'user_id'    => 'integer',//ユーザID
        'user_name'  => 'string', //ユーザ名
        'password'   => 'string', //パスワード
        'token'      => 'string', //トークン
        'time_limit' => 'string', //有効時間
    ];
    public static $primary_key = [
        'user_id',//ユーザID
    ];
}