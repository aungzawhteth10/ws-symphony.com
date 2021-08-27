<?php
namespace messenger\model;
class DmContact extends DataModel
{
    public static $schema = [
        'user_id'     => 'integer',//ユーザID
        'contacts'    => 'string', //連絡先リスト
        'access_time' => 'string', //アクセス時刻
        'is_typing'   => 'string', //タイピングフラグ
    ];
    public static $primary_key = [
        'user_id',//ユーザID
    ];
}