<?php
namespace messenger\db;
class DbMessagesMapper extends MapperBase 
{
    protected $tableName = 'messages';
    protected $modelPath = '\messenger\model\DmMessages';
}