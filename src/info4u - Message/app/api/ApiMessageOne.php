<?php
namespace info4u\api;
class ApiMessageOne extends ApiBase
{
    /*
     * コンストラクタ
     */
    public function __construct() {}
    /*
     * メッセージ取得
     */
    public function getMessage ($userId)
    {   
        $dsn = 'mysql:dbname=u460610115_info4u;host=92.249.44.52';
        $username = 'u460610115_root';
        $password = 'Toorwss9199';
        try {
            $this->pdo = new \PDO($dsn, $username, $password);
        } catch (\PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
        return 'Post Successful Auto Deploy Test...   Just Push';
    }
}
