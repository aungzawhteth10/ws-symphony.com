<?php
namespace messenger\model;
class DmMessageMember extends DataModel
{
    public static $schema = [
        'message_id'     => 'integer',//メッセージID
        'message_member' => 'string', //メッセージ参加者
    ];
    public static $primary_key = [
        'message_id',//メッセージID
    ];
}