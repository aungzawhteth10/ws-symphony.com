<?php
namespace messenger\model;
class DataModel 
{
    private $data = [];
    public function __set($prop, $val)
    {
        $this->data[$prop] = $val;
    }
    public function __get($prop)
    {
        return $this->data[$prop];
    }
    public function toArray()
    {
        error_log(print_r('toarray()', true));
        return $this->data;
    }
    public function isset($prop)
    {
        return isset($this->data[$prop]) ? true : false;
    }
    public function getSchema()
    {
        return $this->schema;
    }
    public function setModelData($data)
    {
        error_log(print_r('schema', true));
        foreach ($data as $key => $value) {
            if (isset(static::$schema[$key])) {
                $this->data[$key] = $value;
            }
        }
    }
}