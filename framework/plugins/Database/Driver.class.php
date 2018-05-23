<?php
namespace WyPhp\Database;
use WyPhp\Error;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/22
 * Time: 11:13
 */
abstract class Driver{
    // 数据库连接ID 支持多个连接
    protected $linkID = [];
    // 当前连接ID
    protected $_linkID = null;
    //PDO操作实例
    protected $PDOStatement = null;
    // 返回或者影响记录数
    protected $numRows = 0;
    // 查询次数
    protected static $queryTimes = 0;
    // 执行次数
    protected static $executeTimes = 0;
    //参数绑定
    protected $bind = [];
    protected $lastSql = '';
    // PDO连接参数
    protected $options = [
        \PDO::ATTR_CASE =>\PDO::CASE_LOWER,
        \PDO::ATTR_ERRMODE =>\PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_ORACLE_NULLS =>\PDO::NULL_NATURAL,
        \PDO::ATTR_STRINGIFY_FETCHES =>false,
    ];
    protected $selectJoin  = [
        'left' =>'LEFT JOIN',
        'all' =>'UNION ALL',
        'union' =>'UNION'
    ];
    // 数据库表达式
    protected $exp = array('eq'=>'=','neq'=>'<>','gt'=>'>','egt'=>'>=','lt'=>'<','elt'=>'<=','notlike'=>'NOT LIKE','like'=>'LIKE','in'=>'IN','notin'=>'NOT IN','not in'=>'NOT IN','between'=>'BETWEEN','not between'=>'NOT BETWEEN','notbetween'=>'NOT BETWEEN');
    // 数据库连接参数配置
    protected $config = [
        'dbtype' =>'',     // 数据库类型
        'host' =>'127.0.0.1', // 服务器地址
        'database' =>'',          // 数据库名
        'user' =>'',      // 用户名
        'password' =>'',          // 密码
        'port' =>3306,        // 端口
        'params' =>[], // 数据库连接参数
        'charset' =>'utf8',      // 数据库编码默认采用utf8
        'prefix' =>'',    // 数据库表前缀
        'master_num' =>1, // 读写分离后 主服务器数量
        'slave_no' =>'', // 指定从服务器序号
    ];
    /**
     * 架构函数 读取数据库配置信息
     * @access public
     * @param array $config 数据库配置数组
     */
    public function __construct($config=''){
        if(!empty($config)) {
            $this->config = array_merge($this->config,$config);
            if(is_array($this->config['params'])){
                $this->options = array_merge($this->options,$this->config['params']);
            }
        }
    }
    /**
     * 连接数据库方法
     * @access public
     */
    public function connect($config) {
        $linkNum = $config['serviceno'] . (isset($config['prefix']) ? $config['prefix'] : CF::get('DEFAULT_DB'));
        if ( !isset($this->linkID[$linkNum]) ) {
            empty($config) and Error::error('not find config!');
            try{
                if(empty($config['dsn'])) {
                    $config['dsn'] = $this->parseDsn($config);
                }
                if(version_compare(PHP_VERSION,'5.3.6','<=')){
                    // 禁用模拟预处理语句
                    $this->options[\PDO::ATTR_EMULATE_PREPARES] = false;
                }
                $this->linkID[$linkNum] = new \PDO($config['dsn'], $config['user'], $config['password'],$this->options);
                $this->linkID[$linkNum]->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch (\PDOException $e) {
                Error::debug('MYSQL PWD ERROR！');
            }
        }
        return $this->linkID[$linkNum];
    }
    /**
     * 释放查询结果
     * @access public
     */
    public function free() {
        $this->PDOStatement = null;
    }
    /**
     * 关闭数据库
     * @access public
     */
    public function close() {
        $this->_linkID = null;
    }
    /**
     * @return string
     */
    public function getSql(){
        return $this->lastSql;
    }
    /**
     * 解析pdo连接的dsn信息
     * @access public
     * @param array $config 连接信息
     * @return string
     */
    protected function parseDsn($config){}
    /**
     * 析构方法
     * @access public
     */
    public function __destruct() {
        // 释放查询
        if ($this->PDOStatement){
            $this->free();
        }
        $this->close();
    }
}