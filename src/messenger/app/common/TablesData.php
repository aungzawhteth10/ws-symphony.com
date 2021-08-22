<?php
namespace messenger\common;
class TablesData
{
    protected $cache;
    public function __construct () {
    }
    public function getLoginTable ()
    {
        $dbLoginMapper = new \messenger\db\DbLoginMapper;
        $dmLogin = new \messenger\model\DmLogin;
        $loginTable =  $dbLoginMapper->find();
        return $loginTable;
    }
    public function getContactTable ()
    {
        $dbContactMapper = new \messenger\db\DbContactMapper;
        $dmContact = new \messenger\model\DmContact;
        $contactTable =  $dbContactMapper->find();
        return $contactTable;
    }
    public function getMessageMemberTable ()
    {
        $dbMessageMemberMapper = new \messenger\db\DbMessageMemberMapper;
        $dmMessageMember = new \messenger\model\DmMessageMember;
        $messageMemberTable =  $dbMessageMemberMapper->find();
        return $messageMemberTable;
    }
    public function getMessagesTable ()
    {
        $dbMessagesMapper = new \messenger\db\DbMessagesMapper;
        $dmMessages = new \messenger\model\DmMessages;
        $messagesTable =  $dbMessagesMapper->find();
        return $messagesTable;
    }
}
