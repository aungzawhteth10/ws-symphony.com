<?php
namespace messenger\db;
class MapperBase 
{
    protected $pdo;
    public function __construct()
    {
        $dsn = 'mysql:dbname=u460610115_messenger;host=sql255.main-hosting.eu';
        $username = 'u460610115_messenger_root';
        $password = 'Toorwss9199';
        try {
            $this->pdo = new \PDO($dsn, $username, $password);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    /*
    * DBからデータを取得する
    */
    public function find($model = NULL)
    {
        // $modelPath = '\App\model\\' . $this->modelName;
        if (is_null($model)) {
            $model = new $this->modelPath;
        }
        $modelArr = $model->toArray();
        $schema = $this->modelPath::$schema;
        $sql = $this->_createSelectSqlStatement($modelArr);
        $stmt = $this->pdo->prepare($sql);
        error_log(print_r($stmt, true));
        $paramArr = [];
        foreach ($modelArr as $key => $value) {
            $param = ':' . $key;
            switch ($schema[$key]) {
                case 'integer':
                    if (is_array($value)) {
                        for ($i = 0; $i < count($value); $i++) {
                            $paramArr[] = (int)$value[$i];
                        }
                    } else {
                        $paramArr[] = intval($value);
                    }
                    break;
                case 'double':
                    $paramArr[] = floatval($value);
                    break;
                case 'string':
                default:
                    $paramArr[] = (string)$value;
                    break;
            }
        }
        $stmt->execute($paramArr);
        $row = $stmt->fetchAll();
        $result = [];
        if (count($row) == 0) {
            return $result;
        }
        foreach ($row as $key => $value) {
            $rowData = [];
            foreach ($schema as $schemaKey => $dataType) {
                $rowData[$schemaKey] = $value[$schemaKey];
            }
            $result[] = $rowData;
        }
        return $result;
    }
    /*
    * SELECT SQL文を作成する。
    */
    public function _createSelectSqlStatement($modelArr)
    {
        $sql= 'SELECT * FROM ' . $this->tableName;
        $jouken = [];
        foreach ($modelArr as $key => $value) {
            if (is_array($value)) {
                $inValArr = [];
                for ($i = 1; $i <= count($value); $i++) {
                    $inValArr[] = '?'; 
                }
                $jouken[] = 'BINARY ' . $key . ' IN (' . implode(', ', $inValArr) .')';
            } else {
                $jouken[] = 'BINARY ' . $key . ' = ?';
            }
        }
        if (count($jouken) > 0) {//条件ありの場合
            $sql .= ' WHERE ' . implode(' AND ', $jouken);
        }
        return $sql;
    }
    /*
    * UPDATE DB更新処理
    */
    public function update($model = NULL)
    {
        if (is_null($model)) {
            $model = new $this->modelPath;
        }
        $modelArr = $model->toArray();
        $schema = $this->modelPath::$schema;
        $sql = $this->_createUpdateSqlStatement($modelArr);
        $stmt = $this->pdo->prepare($sql);
        error_log(print_r($stmt, true));
        $paramArr = [];
        foreach ($modelArr as $key => $value) {
            $param = ':' . $key;
            switch ($schema[$key]) {
                case 'integer':
                    $paramArr[$key] = (int)$value;
                    break;
                case 'string':
                default:
                    $paramArr[$key] = (string)$value;
                    break;
            }
        }
        $pk = $this->modelPath::$primary_key;
        foreach ($pk as $key => $value) {
            $param = ':' . $value;
            switch ($value) {
                case 'integer':
                    $paramArr[$value] = (int)$modelArr[$value];
                    break;
                case 'string':
                default:
                    $paramArr[$value] = (string)$modelArr[$value];
                    break;
            }
        }
        $stmt->execute($paramArr);
        error_log('rowCount:');
        error_log(print_r($stmt->rowCount(), true));
        return $stmt->rowCount();
    }
    /*
    * UPDATE SQL文を作成する。
    */
    public function _createUpdateSqlStatement($modelArr)
    {
        $sql= 'UPDATE ' . $this->tableName . ' SET';
        $updateList = [];
        foreach ($modelArr as $key => $value) {
            $updateList[] = $key . ' =:' . $key;
        }
        if (count($updateList) > 0) {//更新項目あり
            $sql .= ' ' . implode(', ', $updateList);
        }
        $pk = $this->modelPath::$primary_key;
        $jouken = [];
        foreach ($pk as $key => $value) {
            $jouken[] .= $value . '=:' . $value;
        }
        if (count($jouken) > 0) {//条件ありの場合
            $sql .= ' WHERE ' . implode(' AND ', $jouken);
        }
        return $sql;
    }
    /*
    * INSERT DB登録処理
    */
    public function insert($model = NULL)
    {
        if (is_null($model)) {
            $model = new $this->modelPath;
        }
        $modelArr = $model->toArray();
        $schema = $this->modelPath::$schema;
        $sql = $this->_createInsertSqlStatement($modelArr);
        $stmt = $this->pdo->prepare($sql);
        error_log(print_r('$stmt', true));
        error_log(print_r($stmt, true));
        $paramArr = [];
        foreach ($modelArr as $key => $value) {
            $param = ':' . $key;
            switch ($schema[$key]) {
                case 'integer':
                    $paramArr[$key] = (int)$value;
                    break;
                case 'string':
                default:
                    $paramArr[$key] = (string)$value;
                    break;
            }
        }
        $stmt->execute($paramArr);
        return $stmt->rowCount();;
    }
    /*
    * INSERT SQL文を作成する。
    */
    public function _createInsertSqlStatement($modelArr)
    {
        $sql= 'Insert INTO ' . $this->tableName;
        $insertList = [];
        foreach ($modelArr as $key => $value) {
            $insertList['key1'][] = $key;
            $insertList['key2'][] = ':' . $key;
        }
        if (count($insertList) > 0) {//更新項目あり
            $sql .= '(' . implode(', ', $insertList['key1']) . ') VALUES (' . implode(', ', $insertList['key2']) . ')';
        }
        return $sql;
    }
}