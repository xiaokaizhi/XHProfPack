<?php
/**
 * Mysql
 * @author baojunbo <baojunbo@gmail.com>
 */

abstract class lib_mysql {
    protected $_table; // 表名
    protected $_primary; // 主键名

    private static $_pdo = array();
    private static $_data= array();

    /**
     * 获取单行数据
     * @param  string $where  [SQL 条件]
     * @param  string $fields [查询字段]
     * @param  array  $params [预处理参数]
     * @return array
     */
	public function get($where, $fields = '*', $params = array()) {
        $where = $this->_getWhere($where);
        $sql = "SELECT {$fields} FROM " . $this->_table . " WHERE {$where}";
		$sqlKey = $this->_getSqlKey('get', $sql, $params);
        if (!self::$_data[$sqlKey]) {
    		$pdo = $this->_getPdo('r');
            $pdoStatement = self::_getPDOStatement($pdo, $sql, $params);
            self::$_data[$sqlKey] = $pdoStatement->fetch(PDO::FETCH_ASSOC);
            $pdoStatement->closeCursor();
        }
        return self::$_data[$sqlKey];
    }

    /**
     * 获取多行数据
     * @param  string $where  [SQL 条件]
     * @param  string $fields [查询字段]
     * @param  array  $params [预处理参数]
     * @return array
     */
    public function mget($where, $fields = '*', $params = array()) {
        $where = $this->_getWhere($where);
        $sql = "SELECT {$fields} FROM " . $this->_table . " WHERE {$where}";
        $sqlKey = $this->_getSqlKey('mget', $sql, $params);
        if (!self::$_data[$sqlKey]) {
            $pdo = $this->_getPdo('r');
            $pdoStatement = self::_getPDOStatement($pdo, $sql, $params);
            self::$_data[$sqlKey] = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            $pdoStatement->closeCursor();
        }
        return self::$_data[$sqlKey];
    }

    public function pget($where, $fields = '*', $params = array(), $config = array()) {
        //return lib_MysqlPage::get($this, $where, $fields, $params, $config);
    }

    /**
     * 更新或插入
     * @param  array  $data   [要更新或插入的数据]
     * @param  string $where  [SQL 条件]
     * @param  array  $params [预处理参数]
     * @return int
     */
    public function set($data, $where = null, $params = null) {
        $sql = null;
        if (!$where) { // 插入数据
            $current = current($data);
            $fields  = array();
            $values  = array();
            if (!is_array($current)) {
                foreach ($data as $key => $value) {
                    $fields[] = $key;
                    $values[] = (is_numeric($value) || substr($value, 0, 1)) ? $value : "'{$value}'";
                }
                $values = "(" . join(', ', $values) . ")";
            } else {
                $params = $valuesT = array();
                foreach($data as $i => $values) {
                    $filedsT = array();
                    foreach($values as $key => $value) {
                        if (!in_array($key, $fields)) $fields[] = $key;
                        $ketyT = ":{$key}{$i}";
                        $filedsT[] = $ketyT;
                        $params[$ketyT] = $value;
                    }
                    $valuesT[] = "(" . join(", ", $filedsT) . ")";
                }
                $values = join(", ", $valuesT);
            }

            $fields = join(", ", $fields);
            $sql = "INSERT INTO " . $this->_table . " ({$fields}) VALUES {$values}";
        } else { // 更新数据
            $where = $this->_getWhere($where);
            if ($data) {
                $fieldsValues = array();
                foreach($data as $key => $val) {
                    if (is_numeric($val) || substr($val, 0, 1) == ':') {
                        $fieldsValues[] = "`{$key}` = {$val}";
                    } else {
                        $fieldsValues[] = "`{$key}` = '{$val}'";
                    }
                }
                $setFields = join(", ", $fieldsValues);
                $sql = "UPDATE " . $this->_table . " SET {$setFields} WHERE {$where}";
            }
		}
        if ($sql) {
            $pdo = $this->_getPdo('w');
            $pdoStatement = self::_getPDOStatement($pdo, $sql, $params);
            if (!$where) {
                $res = $pdo->lastInsertId();
            } else {
                $res = $pdoStatement->rowCount();
            }
            if ($res) self::$_data = array();
            return $res;
        }
    }

    /**
     * 删除
     * @param  string $where  [SQL 条件]
     * @param  array  $params [预处理参数]
     * @return int
     */
    public function del($where, $params = null) {
        $where = $this->_getWhere($where);
        $sql = "DELETE FROM " . $this->_table . " WHERE {$where}";
    	$pdo = $this->_getPdo('w');
        $pdoStatement = self::_getPDOStatement($pdo, $sql, $params);
        return $pdoStatement->rowCount();
    }

    private static function _getPDOStatement($pdo, $sql, $params) {
        $pdoStatement = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    private function _getPdo($rw) {
        if (!$this->_table) throw new ErrorException("\$_table is empty!", 30002);
        if (!$this->_primary) throw new ErrorException("\$_primary is empty!", 30003);

        $server = $this->_getServer($rw); // 获取服务器信息，在子类中实现
        $dsn    = &$server['dsn'];
        $user   = &$server['user'];
        $pass   = &$server['pass'];
        $params = &$server['params'];
        $pdoKey = md5("{$dsn}{$user}{$pass}");
        if (!isset(self::$_pdo[$pdoKey])) {
            $debugKey = "pdo::construct({$dsn})";
            $pdo = new PDO($dsn, $user, $pass, $params);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_TIMEOUT, 1); // 设置超时
            self::$_pdo[$pdoKey] = $pdo;
        }
        return self::$_pdo[$pdoKey];
    }

    private function _getWhere($where) {
        $fields = "*";
        $params = array();
        if (is_numeric($where)) {
            $params= array($where);
            $where = $this->_primary . " = ?";
        }
        return $where;
    }

    private function _getSqlKey($method, $sql, $params) {
        if ($params) {
            $keys   = array_keys($params);
            $values = array_values($params);
            $sql = str_replace($keys, $values, $sql);
        }
        $sqlKey = md5("{$method}:{$sql}");
        return $sqlKey;
    }
}
