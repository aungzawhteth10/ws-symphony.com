<?php
namespace messenger\db;
class DbMessageMemberMapper extends MapperBase 
{
    protected $tableName = 'message_member';
    protected $modelPath = '\messenger\model\DmMessageMember';
}