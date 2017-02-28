<?php


namespace core\library;


class Model {
    public $conn;
    private static $_instance = null;
    private $sql;

    private function __construct() {
        $db = Config::getAll('db');
        $this->conn = @ mysql_connect($db['host'], $db['username'], $db['passwd'])
        or die("连接数据库失败！");
        @ mysql_select_db($db['dbname']) or die("选择数据库失败！");
        return $this->conn;
    }

    private function selectsql() {

    }

    /**
     * 查询数据库
     * @param       $table
     * @param array $condition
     * @param array $field
     * @return array
     */
    public function select($table, $condition = array(), $field = array()) {
        $where = '';
        if (!empty($condition)) {

            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $fieldstr = '';
        if (!empty($field)) {

            foreach ($field as $k => $v) {
                $fieldstr .= $v . ',';
            }
            $fieldstr = rtrim($fieldstr, ',');
        } else {
            $fieldstr = '*';
        }
        $this->sql = "select {$fieldstr} from {$table} {$where}";
        $result    = mysql_query($this->sql, $this->conn);
        $resuleRow = array();
        $i         = 0;
        while ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resuleRow[$i][$k] = $v;
            }
            $i++;
        }
        return $resuleRow;
    }

    /**
     * 添加一条记录
     * @param $table
     * @param $data
     * @return bool|int
     */
    public function insert($table, $data) {
        $values = '';
        $datas  = '';
        foreach ($data as $k => $v) {
            $values .= $k . ',';
            $datas .= "'$v'" . ',';
        }
        $values    = rtrim($values, ',');
        $datas     = rtrim($datas, ',');
        $this->sql = "INSERT INTO  {$table} ({$values}) VALUES ({$datas})";
        if (mysql_query($this->sql)) {
            return mysql_insert_id();
        } else {
            return false;
        };
    }

    /**
     * 修改一条记录
     * @param       $table
     * @param       $data
     * @param array $condition
     * @return resource
     */
    public function update($table, $data, $condition = array()) {
        $where = '';
        if (!empty($condition)) {

            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $updatastr = '';
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $updatastr .= $k . "='" . $v . "',";
            }
            $updatastr = 'set ' . rtrim($updatastr, ',');
        }
        $this->sql = "update {$table} {$updatastr} {$where}";
        return mysql_query($this->sql);
    }

    /**
     * 删除记录
     * @param $table
     * @param $condition
     * @return resource
     */
    public function delete($table, $condition) {
        $where = '';
        if (!empty($condition)) {

            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $this->sql = "delete from {$table} {$where}";
        return mysql_query($this->sql);

    }


    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __clone() {

    }

}