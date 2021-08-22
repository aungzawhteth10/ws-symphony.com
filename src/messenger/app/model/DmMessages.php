<?php
namespace messenger\model;
class DmMessages extends DataModel
{
    public static $schema = [
        'message_id'  => 'integer',//メッセージID
        'messages'    => 'string', //メッセージ
    ];
    public static $primary_key = [
        'message_id',//メッセージID
    ];
}