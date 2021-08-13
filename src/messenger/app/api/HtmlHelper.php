<?php
namespace messenger\api;
class HtmlHelper
{
    /*
     * コンストラクタ
     */
    public function __construct() {}
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
}