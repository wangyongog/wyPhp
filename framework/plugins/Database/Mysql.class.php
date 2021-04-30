<?php
namespace WyPhp\Database;

use WyPhp\Logs;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/21
 * Time: 16:05
 */
class Mysql extends Driver{
    public function __construct(array $config=[]){
        $this->bind = [];
        if(!empty($config)) {
            $this->config = array_merge($this->config ,$config);
        }
    }

    /**
     * sql预处理
     * @param $query sql语句
     * @return bool
     */
    private function _Init($query){
        if ( !$this->_linkID ) $this->_linkID = $this->connect($this->config);
        if (!$this->_linkID || !$query){
            $this->ExceptionLog('PDOStatement NOT find', $query);
            return false;
        }
        $query = trim(str_replace("\r", " ", $query));
        try {
            $this->PDOStatement = $this->_linkID->prepare($query);
            if(false === $this->PDOStatement){
                $this->ExceptionLog('PDOStatement NOT find', $query);
                return false;
            }
            if (!empty($this->bind)) {
                foreach ($this->bind as $key => $value) {
                    /*switch ($value) {
                        case is_int($value):
                            $type = \PDO::PARAM_INT;
                            break;
                        case is_bool($value):
                            $type = \PDO::PARAM_BOOL;
                            break;
                        case is_null($value):
                            $type = \PDO::PARAM_NULL;
                            break;
                        default:
                            $type = \PDO::PARAM_STR;
                    }*/
                    $this->PDOStatement->bindValue($key, $value, \PDO::PARAM_STR);
                }
            }
            $this->lastSql = $query;
            $this->PDOStatement->execute();
        } catch (\PDOException $e) {
            $this->ExceptionLog($e->getMessage(), $query);
        }
        $this->bind = [];
    }
    /**
     * 执行sql，主用查询
     * @param $query
     * @return bool|mixed
     */
    public function query($query ,$fetch_first=false){
        if (!empty($this->PDOStatement) ) $this->free();
        $this->_Init($query);
        self::$queryTimes++;
        $rawStatement = explode(' ', preg_replace("/\s+|\t+|\n+/", " ", $query));
        $statement = strtolower($rawStatement[0]);
        if (in_array($statement, ['select','show'])) {
            if($fetch_first){
                return $this->PDOStatement->fetch(\PDO::FETCH_ASSOC);
            }
            $result = $this->PDOStatement->fetchAll(\PDO::FETCH_ASSOC);
            $this->numRows = count( $result );
            return $result;
        }
        if(in_array($statement, ['insert','replace'])){
            return $this->lastInsertId();
        }
        if (in_array($statement, ['update','delete'])) {
            return $this->PDOStatement->rowCount();
        }
        return false;
    }

    /**
     * 执行sql
     * @param $query
     * @return bool
     */
    public function execute($query){
        if (!empty($this->PDOStatement) ) $this->free();
        self::$executeTimes++;
        $this->_Init($query);
        $rawStatement = explode(' ', preg_replace("/\\s+|\t+|\n+/", ' ', $query));
        $statement = strtolower($rawStatement[0]);
        if(in_array($statement, ['insert','replace'])){
            return $this->lastInsertId();
        }
        return $this->PDOStatement->rowCount();
    }

    /**
     * 查询多行
     * @param $table
     * @param string $fields
     * @param null $condition
     * @param string $order
     * @param string $limit
     * @param int $page
     * @param string $group
     * @param string $having
     * @return bool
     */
    public function select($table, $fields='*', $condition=null, $order='', $limit='', $page=1 , $group='', $having = ''){
        $sql = 'SELECT '.$this->parseFields($fields).' FROM '.$this->parseTable($table);
        if ($condition != null) {
            $sql .= $this->parseWhere($condition);
        }
        if ($group) {
            $sql .= ' GROUP BY '.$group;
        }
        if ($order) {
            $sql .= ' ORDER BY '.$order;
        }
        if ($having) {
            $sql .= ' HAVEING '.$having;
        }
        if ($limit) {
            $startSet = ($page - 1) * $limit;
            $sql .= ' LIMIT '.$startSet.','.$limit;
        }
        return $this->query($sql);
    }

    /**
     * 获取一行数据
     * @param $table
     * @param $fields
     * @param null $condition
     * @param string $order
     * @param string $group
     * @param string $having
     * @return bool|mixed
     */
    public function fetch_first($table , $fields, $condition=null, $order='', $group='', $having = ''){
        $sql = 'SELECT '.$this->parseFields($fields).' FROM '.$this->parseTable($table);
        if ($condition != null) {
            $sql .= $this->parseWhere($condition);
        }
        if ($group) {
            $sql .= ' GROUP BY '.$group;
        }
        if ($order) {
            $sql .= ' ORDER BY '.$order;
        }
        if ($having) {
            $sql .= ' HAVEING '.$having;
        }
        $sql .= ' LIMIT 1';
        return $this->query($sql, true);
    }
    public function result_first($table , $fields, $condition=null, $order='', $group='', $having = ''){
        $sql = 'SELECT '.$this->parseFields($fields).' FROM '.$this->parseTable($table);
        if ($condition != null) {
            $sql .= $this->parseWhere($condition);
        }
        if ($group) {
            $sql .= ' GROUP BY '.$group;
        }
        if ($order) {
            $sql .= ' ORDER BY '.$order;
        }
        if ($having) {
            $sql .= ' HAVEING '.$having;
        }
        $sql .= ' LIMIT 1';
        $result = $this->query($sql, true);
        return isset($result[$fields]) ? $result[$fields] : '';
    }
    public function count($table , $condition=null){
        $sql = 'SELECT COUNT(*) AS count FROM '.$this->parseTable($table);
        if ($condition != null) {
            $sql .= $this->parseWhere($condition);
        }
        $sql .= ' LIMIT 1';
        $result = $this->query($sql, true);
        $this->numRows = $result['count'];
        return isset($result['count']) ? $result['count'] : 0;
    }
    /**
     * 编辑操作
     * @param $table
     * @param $data
     * @return bool
     */
    public function update($table, $data, $condition =null){
        if(empty($data) || !is_array($data)){
            return false;
        }
        $sql = 'UPDATE `'.$this->config['prefix'] .$table.'`' . $this->parseSet($data);
        if ($condition != null) {
            $sql .= $this->parseWhere($condition);
        }
        return $this->execute($sql);
    }

    /**
     * 删除
     * @param $table
     * @param null $condition
     * @return bool
     */
    public function delete($table, $condition =null){
        if(empty($table)){
            return false;
        }
        $sql = 'DELETE FROM `'.$this->config['prefix'] .$table.'`';
        if ($condition != null) {
            $sql .= $this->parseWhere($condition);
        }
        return $this->execute($sql);
    }
    /**
     * 写入操作
     * @param $table 表名
     * @param $data  数据
     * @param bool $replace
     * @return bool
     */
    public function insert($table, $data, $replace=false){
        if(empty($data) || !is_array($data)){
            return false;
        }
        $fields = $values = [];
        foreach ($data as $key=>$val){
            $field = count($this->bind);
            $fields[] = $key;
            $values[] = ':'.$field;
            $this->bindParam($field, $val,false);
        }
        $sql = (true===$replace ? 'REPLACE' : 'INSERT').' INTO `'.$this->config['prefix'] .$table.'` ('.$this->parseFields($fields).') VALUES ('.implode(',', $values).')';
        return $this->execute($sql);
    }

    /**
     * ；批量插入
     * @param $table
     * @param $data
     * @param bool $replace
     * @return bool
     */
    public function multi_insert($table, $data, $replace=false){
        $fields = array_keys($data[0]);
        foreach($data as $v){
            $value = [];
            while(list($key,$val) = each($v)){
                $name = count($this->bind);
                $value[] = ':'.$name;
                $this->bindParam($name, $val,false);
            }
            $values[] = '('.implode(',', $value).')';
        }
        $sql = (true===$replace ? 'REPLACE' : 'INSERT').' INTO `'.$this->config['prefix'] .$table.'` ('.$this->parseFields($fields).') VALUES '.implode(',', $values);
        return $this->execute($sql);
    }
    /**
     * 获得查询次数
     * @access public
     * @param boolean $execute 是否包含所有查询
     * @return integer
     */
    public function getQueryTimes($execute=false){
        return $execute ? self::$queryTimes + self::$executeTimes : self::$queryTimes;
    }

    /**
     * 获得执行次数
     * @access public
     * @return integer
     */
    public function getExecuteTimes(){
        return self::$executeTimes;
    }
    /**
     * table分析
     * @param $tables
     * @return string
     */
    protected function parseTable($tables) {
        $arr = $leftStr = [];
        $onstr = '';
        if(is_array($tables)) {
            foreach($tables as $table=>$val){
                $count = count($arr);
                $key = $count >0 ? $count -1 : 0;
                if(in_array($table, ['left','left1','all','union'])){
                    $onstr = ' ON '.$val;
                    $arr[$key] = $arr[$key].' %'.strtoupper($table).'% ';
                    continue;
                }
                if(!$onstr){
                    $arr[] = '`'.$this->config['prefix'].$table.'`' . ($val ? ' AS '.$val : '') ;
                }
                if($onstr){
                    $arr[$key] = $arr[$key]. '`'.$this->config['prefix'].$table.'`' . ($val ? ' AS '.$val : '').' '.$onstr;
                    $onstr = '';
                }
            }
            $tables = implode(',',$arr);
            $tables = $this->parseSql($tables);
        }else{
            $tables = '`'.$this->config['prefix'].$tables.'`';
        }
        return $tables;
    }
    /**
     * 替换SQL语句中表达式
     * @access public
     * @param array $options 表达式
     * @return string
     */
    public function parseSql($sql){
        $sql   = str_replace(
            ['%LEFT%','%LEFT1%','%ALL%','%UNION%'],
            [
                $this->selectJoin['left'],
                $this->selectJoin['left'],
                $this->selectJoin['all'],
                $this->selectJoin['union']
            ],$sql);
        return $sql;
    }
    /**
     * set分析
     * @param $data 数据
     * @return string
     */
    protected function parseSet($data) {
        $set = [];
        foreach ($data as $key=>$val){
            if(is_array($val) && 'exp' == $val[0]){
                $set[] = $key.'='.$val[1];
                continue;
            }
            $field = count($this->bind);
            $set[] = $key.'=:'.$field;
            $this->bindParam($field, $val ,false);
        }
        return ' SET '.implode(',', $set);
    }
    /**
     * 字段和表名处理
     * @access protected
     * @param string $key
     * @return string
     */
    protected function parseKey(&$key) {
        $key   =  trim($key);
        if(!is_numeric($key) && !preg_match('/[,\'\"\*\(\)`.\s]/',$key)) {
            $key = '`'.$key.'`';
        }
        return $key;
    }
    /**
     * value分析
     * @access protected
     * @param mixed $value
     * @return string
     */
    protected function parseValue($value) {
        if(is_string($value)) {
            $value = '\''.$this->escapeString($value).'\'';
        }elseif(is_array($value)) {
            $value =  array_map(array($this, 'parseValue'),$value);
        }
        return $value;
    }
    /**
     * fields分析
     * @access public
     * @param array $options 表达式
     * @return string
     */
    public function parseFields($fields){
        return is_array($fields) ? implode(',', array_map(array($this,'parseKey'),$fields)) : $fields;
    }
    /**
     * 参数绑定
     * @access protected
     * @param string $name 绑定参数名
     * @param mixed $value 绑定值
     * @return void
     */
    protected function bindParam($name, $value, $escapeString=true){
        $this->bind[':'.$name] = is_string($value) ? $this->escapeString($value) : $value;
    }
    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str  SQL字符串
     * @return string
     */
    public function escapeString($str) {
        //return addslashes($str);
        return MAGIC_QUOTES_GPC && is_string($str) ? stripslashes($str) : $str;
    }
    /**
     * where分析
     * @access protected
     * @param mixed $where
     * @return string
     */
    protected function parseWhere($where) {
        $whereStr = '';
        if(is_array($where) ){
            foreach($where as $key=>$val){
                $operate = isset($val['operate']) ? ' '.$val['operate'].' ' : ' AND ';
                if(true === strpos($key, '_')) {
                    // 解析特殊条件表达式
                    $whereStr .= $this->parseThinkWhere($key, $val);
                }
                if(is_array($val)){
                    $multi = is_array($val) && isset($val['_multi']);
                    $key = trim($key);
                    if(strpos($key,'|') === true) { // 支持 name|title|nickname 方式定义查询字段
                        $array = explode('|', $key);
                        $str = [];
                        foreach ($array as $m=>$k){
                            $v = $multi ? $val[$m] : $val;
                            $str[] = $this->parseWhereItem($k, $v);
                        }
                        $whereStr .= '( '.implode(' OR ',$str).' )';
                    }elseif(strpos($key,'&')){
                        $array =  explode('&', $key);
                        $str = [];
                        foreach ($array as $m=>$k){
                            $v = $multi ? $val[$m] : $val;
                            $str[]  = '('.$this->parseWhereItem($k, $v).')';
                        }
                        $whereStr .= '( '.implode(' AND ',$str).' )';
                    }else{
                        $whereStr .= $this->parseWhereItem($key, $val);
                    }
                    $whereStr .= $operate;
                }else{
                    $field = count($this->bind);
                    $arr[] = $key .'=:'.$field;
                    $this->bindParam($field, $val);
                }
            }
            $whereStr .= !empty($arr) ? implode(' AND ',$arr) : '';
            $whereStr = trim($whereStr,' AND ');
            //Logs::save($whereStr);
            //$where = implode(' AND ',$arr);
        }
        if(is_string($where)){
            $whereStr = $where;
        }
        return empty($whereStr) ? '' : ' WHERE '.$whereStr;
    }

    /**
     * 条件逻辑处理
     * @param $key
     * @param $val
     * @return string
     */
    protected function parseWhereItem($key, $val) {
        $whereStr = '';
        if(is_array($val)) {
            if(is_string($val[0])) {
                $exp = strtolower($val[0]);
                if(in_array($exp,['eq','neq','gt','egt','lt','elt'])) { // 比较运算
                    $whereStr .= $key . ' ' . $this->exp[$exp] . ' ' . $this->parseValue($val[1]);
                }
                if(in_array($exp, ['notlike','like'])){// like 运算
                    if(is_array($val[1])) {
                        $likeLogic = isset($val[2]) ? strtoupper($val[2]) : 'OR';
                        if(in_array($likeLogic,['AND','OR','XOR'])){
                            $like = [];
                            foreach ($val[1] as $item){
                                $like[] = $key.' '.$this->exp[$exp].' '.$this->escapeString($item);
                            }
                            $whereStr .= '('.implode(' '.$likeLogic.' ',$like).')';
                        }
                    }else{
                        $whereStr .= $key.' '.$this->exp[$exp].' '.$this->escapeString($val[1]);
                    }
                }
                if('exp' == $exp ){ // 使用表达式
                    $whereStr .= $key.' '.$val[1];
                }
                if(in_array($exp, ['notin','not in','in'])) { // IN 运算
                    if(isset($val[2]) && 'exp'==$val[2]) {
                        $whereStr .= $key.' '.$this->exp[$exp].' '.$val[1];
                    }else{
                        $val[1] = is_array($val[1]) ? implode(',', $this->parseValue($val[1])) : $val[1];
                        $val[1] and $whereStr .= $key.' '.$this->exp[$exp].' ('.$val[1].')';
                    }
                }
                if(in_array($exp, ['notbetween','not between','between'])){ // BETWEEN运算
                    $data = is_string($val[1]) ? explode(',',$val[1]) : $val[1];
                    $whereStr .=  $key.' '.$this->exp[$exp].' '.$this->parseValue($this->escapeString($data[0])).' AND '.$this->escapeString($data[1]);
                }
            }
        }
        return $whereStr;
    }
    /**
     * 特殊条件分析
     * @access protected
     * @param string $key
     * @param mixed $val
     * @return string
     */
    protected function parseThinkWhere($key,$val) {
        $whereStr = '';
        switch($key) {
            case '_string':
                // 字符串模式查询条件
                $whereStr = $val;
                break;
            case '_complex':
                // 复合查询条件
                $whereStr = substr($this->parseWhere($val),6);
                break;
            case '_query':
                // 字符串模式查询条件
                parse_str($val,$where);
                if(isset($where['_logic'])) {
                    $op   =  ' '.strtoupper($where['_logic']).' ';
                    unset($where['_logic']);
                }else{
                    $op   =  ' AND ';
                }
                $array   =  array();
                foreach ($where as $field=>$data)
                    $array[] = $this->parseKey($field).' = '.$this->parseValue($data);
                $whereStr   = implode($op,$array);
                break;
        }
        return '( '.$whereStr.' )';
    }
    /**
     * 解析pdo连接的dsn信息
     * @access public
     * @param array $config 连接信息
     * @return string
     */
    protected function parseDsn($config){
        $dsn = 'mysql:dbname=' . $config['database'] . ';host=' . $config['host'] . ';charset='.$config['charset'].';port='.$config['port'];
        if(!empty($config['socket'])){
            $dsn  .= ';unix_socket='.$config['socket'];
        }
        if(!empty($config['charset'])){
            //为兼容各版本PHP,用两种方式设置编码
            $this->options[\PDO::MYSQL_ATTR_INIT_COMMAND]    =   'SET NAMES '.$config['charset'];
            //$dsn  .= ';charset='.$config['charset'];
        }
        return $dsn;
    }
    /**
     * 插入编号
     * @return mixed
     */
    public function lastInsertId(){
        return $this->_linkID->lastInsertId();
    }
    /**
     * 开始
     * @return mixed
     */
    public function beginTransaction(){
        return $this->_linkID->beginTransaction();
    }
    /**
     * 提交
     * @return mixed
     */
    public function commit(){
        return $this->_linkID->commit();
    }
    /**
     * 回滚
     * @return mixed
     */
    public function rollBack(){
        return $this->_linkID->rollBack();
    }
}