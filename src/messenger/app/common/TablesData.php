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
}
