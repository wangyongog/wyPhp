<?php
namespace WyPhp;

class DB{
    // 数据库对象池
    private static $_db = [];
    // 当前链接
    private static $_link;

    static function _connect(array $options=[]) {
        $db = isset($options['prefix']) ? $options['prefix'] : CF('DEFAULT_DB');
        $master = isset($options['slave']) ? $options['slave'] : 'master';
        if(!isset(self::$_db[$db][$master])){
            $dbConfig = CF($db);
            if(empty($dbConfig)) {
                Error::error('DB CONFIG NOT');
            }
            $config = self::parseConfig($options, $dbConfig[$master]);
            $config['serviceno'] = $master;
            $class = 'WyPhp\\Database\\'.ucwords(strtolower($config['dbtype']));
            if(!class_exists($class)){
                Error::error('NOT find '.$class);
            }
            self::$_db[$db][$master] = new $class($config);
        }
        self::$_link = self::$_db[$db][$master];
    }
    /**
     * 数据库连接参数解析,库的选择，以表前缀决定
     * @static
     * @access private
     * @param mixed $config
     * @return array
     */
    static function parseConfig(array $options=[], $configStr=''){
        $configStr = str_replace([':',','],['=','&'], $configStr);
        parse_str($configStr, $config);
        !empty($options) and $config = array_merge($config, $options);
        return $config;
    }


    /**
     * 判断读写分离
     * @param $params 服务器相关配置信息
     * @param bool $master  是否连接从服务器，true否，false从服务器 用于insert,select update,del的区分
     * @return mixed
     */
    static function checkSlave($params, $master=true){
        //开启读写分离，并且是从服务器，链接从服务器
        if(CF('RW_SEPARATE') === true && $master === false){
            //指定了从库，以指定为准
            $params['slave'] = isset($params['slave']) ? $params['slave'] : 'slave';
        }
        self::_connect($params);
    }

    /**
     * 原生SQL操作
     * @param $sql
     * @param array $params
     * @param bool $master 是否调用从服务器 true 否，false是
     * @return mixed
     */
    public static function query($sql, $params=[], $master=false){
        self::checkSlave($params,$master);
        return self::$_link->query($sql);
    }

/**
 * 查询
 * @param $table 表名 array|string
 * $table = array(
 * 'member' =>'m',
 * 'left' =>'m.uid=md.uid',
 * 'member_data' =>'md',
 * 'left1' =>'m.uid=a.uid',
 * 'attachments' =>'a'
 * );
 * @param string $fields 字段 array|string ['m.username AS U','m.realname','m.password','md.yqcode']
 * @param null $condition 条件
 * @param string $order 排序
 * @param string $limit
 * @param int $page
 * @param string $group
 * @param string $having
 * @param array $params prefix=>表前缀，分库用，slave=>从服务标示
 * @return mixed
 */
    public static function fetch_all($table, $fields='*', $condition=null, $order='', $limit='', $page=1 , $group='', $having = '', $params=[]){
        self::checkSlave($params, false);
        return self::$_link->select($table , $fields, $condition,$order,$limit,$page,$group,$having);
    }

    /**
     * 查询，返回一行数据
     * @param $table
     * @param string $fields
     * @param null $condition
     * @param string $order
     * @param string $group
     * @param string $having
     * @param array $params  prefix=>表前缀，分库用，slave=>从服务标示
     * @return mixed
     */
    public static function fetch_first($table, $fields='*', $condition=null, $order='', $group='', $having = '', $params=[]){
        self::checkSlave($params, false);
        return self::$_link->fetch_first($table , $fields, $condition, $order,$group, $having);
    }

    /**
     * 获取一个字段数
     * @param $table
     * @param string $fields
     * @param null $condition
     * @param string $order
     * @param string $group
     * @param string $having
     * @param array $params
     * @return mixed
     */
    public static function result_first($table, $fields='*', $condition=null, $order='', $group='', $having = '', $params=[]){
        self::checkSlave($params, false);
        return self::$_link->result_first($table , $fields, $condition, $order,$group, $having);
    }

    /**
     * 获取总数
     * @param $table
     * @param null $condition
     * @param array $params
     */
    public static function count($table, $condition=null, $params=[]){
        self::checkSlave($params);
        return self::$_link->count($table,$condition);
    }
    static function numRows($params=[]){
        self::checkSlave($params);
        return self::$_link->numRows;
    }
    /**
     * 删除
     * @param $table
     * @param $condition  array|string  uid=2 and sss=3
     * @param array $params
     */
    public static function delete($table, $condition=null , array $params=[]){
        self::checkSlave($params);
        return self::$_link->delete($table,$condition);
    }

    /**
     * 修改数据
     * @param $table
     * @param array $data 数据
     * @param array $condition 条件
     * @param array $params
     */
    public static function update($table, $data, $condition=null, array $params=[]){
        self::checkSlave($params);
        return self::$_link->update($table, $data,$condition);
    }

    /**
     * 添加数据
     * @param $table 表名
     * @param $data 数据
     * @param bool $replace 是否替换添加
     * @param array $params [prefix=>表前缀，分库用，slave=>从服务标示]
     */
    public static function insert($table, $data, $replace=false, $params=[]){
        self::checkSlave($params);
        return self::$_link->insert($table, $data, $replace);
    }
    /**
     * insert//批量插入
     * @return $table	表名
     * @param array $data	欲插入的数据
     * $data = array(
     *      array(
     *          'id' => 111,
     *          'uid' => 222
     *      ),
     *      array(
     *          'id' => 111,
     *          'uid' => 222
     *      )
     * )
     * @param bool $replace	替换插入
     * @return int|false	新插入行的id 或 失败
     */
    public static function multi_insert($table ,$data=[],array $params=[]){
        if(empty($data) || empty($table)){
            return false;
        }
        self::checkSlave($params);
        return self::$_link->multi_insert($table ,$data);
    }
    static function queryTimes(){
        return empty(self::$_link) ? 0 : self::$_link->getQueryTimes();
    }
    static function executeTimes(){
        return empty(self::$_link) ? 0 : self::$_link->getExecuteTimes();
    }
    public static function affectedRrows(array $params=[]) {

    }
    public static function insertId(array $params=[]) {
        self::checkSlave($params);
        return self::$_link->lastInsertId();
    }
    public static function close(array $params=[]) {
        self::checkSlave($params);
        self::$_link->free();
        self::$_link->close();
    }
    public static function beginTransaction(array $params=[]){
        self::checkSlave($params);
        return self::$_link->beginTransaction();
    }
    public static function commit(array $params=[]){
        self::checkSlave($params);
        return self::$_link->commit();
    }
    public static function rollBack(array $params=[]){
        self::checkSlave($params);
        return self::$_link->rollBack();
    }
    static function getsql(){
        return self::$_link->getSql();
    }
    /**
     * 数据操作方法
     * @param $method
     * @param $params
     * @return mixed
     */
    static public function __callStatic($method, $params){
        return call_user_func_array(array(self::$_link, $method), $params);
    }
}