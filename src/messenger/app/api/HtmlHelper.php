<?php
namespace messenger\api;
class HtmlHelper
{
    private $tablesData;
    /*
     * コンストラクタ
     */
    public function __construct() {
        $this->tablesData = new \messenger\common\TablesData;
    }
    /*
     * 空有りの選択肢を取得する
     * @param string $bunrui
     * 
     * @return $list 空有り選択肢
     */
    public function getJsonKara($bunrui)
    {    
        $dbCmTableMapper = new \App\db\DbCmTableMapper;
        $dmCmTable = new \App\model\DmCmTable;
        $dmCmTable->bunrui_id = $bunrui;
        $cmTable = $dbCmTableMapper->find($dmCmTable);
        $result[] = [
            'id'    => '',
            'value' => ''
        ];
        foreach ($cmTable as $key => $value) {
            $result[] = [
                'id'    => $value['id'],
                'value' => $value['name']
            ];
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 空なしの選択肢を取得する
     * @param string $bunrui
     * 
     * @return $list 空有り選択肢
     */
    public function getJson($bunrui)
    {    
        $dbCmTableMapper = new \App\db\DbCmTableMapper;
        $dmCmTable = new \App\model\DmCmTable;
        $dmCmTable->bunrui_id = $bunrui;
        $cmTable = $dbCmTableMapper->find($dmCmTable);
        foreach ($cmTable as $key => $value) {
            $result[] = [
                'id'    => $value['id'],
                'value' => $value['name']
            ];
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    public function getUserName($user_id)
    {    
        $cache_file_path = getcwd() . '/src/messenger/app/files/cache/cache.json';
        $cache = json_decode(file_get_contents($cache_file_path), TRUE);
        if (isset($cache['loginTable'])) {
            $loginTable = $cache['loginTable'];
        } else {
            $loginTable = $this->tablesData->getLoginTable();
            $cache['loginTable'] = $loginTable;
        }
        $json_data = json_encode($cache, JSON_UNESCAPED_UNICODE);
        file_put_contents($cache_file_path, $json_data);
        $loginUserNameById = array_column($loginTable, 'user_name', 'user_id');
        $user_name = $loginUserNameById[$user_id] ?? "Username not found";
        error_log(print_r($user_id, true));
        return $user_name;
    }
}
