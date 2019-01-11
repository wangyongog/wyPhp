<?php
namespace WyPhp\Database;

use WyPhp\Error;

class Mongo extends Driver{
    protected $_mongo           =   null; // MongoDb Object
    protected $_collection      =   null; // MongoCollection Object
    protected $_dbName          =   ''; // dbName
    protected $_collectionName  =   ''; // collectionName
    protected $_cursor          =   null; // MongoCursor Object
    protected $comparison       =   array('neq'=>'ne','ne'=>'ne','gt'=>'gt','egt'=>'gte','gte'=>'gte','lt'=>'lt','elt'=>'lte','lte'=>'lte','in'=>'in','not in'=>'nin','nin'=>'nin');
    /**
     * 架构函数 读取数据库配置信息
     * @access public
     * @param array $config 数据库配置数组
     */
    public function __construct($config=[]){
        if ( !class_exists('mongoClient') ) {
            Error::error('mongoClient NOT Driver');
        }
        if(!empty($config)) {
            $this->config = array_merge($this->config,$config);
        }
    }
    /**
     * 连接数据库方法
     * @access public
     */
    public function connect($config='',$linkNum=0) {
        if ( !isset($this->linkID[$linkNum]) ) {
            if(empty($config))  $config =   $this->config;
            $host = 'mongodb://'.($config['user']?"{$config['user']}":'').($config['password']?":{$config['password']}@":'').$config['host'].($config['host']?":{$config['host']}":'').'/'.($config['database']?"{$config['database']}":'');
            try{
                $this->linkID[$linkNum] = new \mongoClient( $host,$this->config['params']);
            }catch (\MongoConnectionException $e){
                Error::error($e->getmessage());
            }
        }
        return $this->linkID[$linkNum];
    }
    /**
     * 切换当前操作的Db和Collection
     * @access public
     * @param string $collection  collection
     * @param string $db  db
     * @param boolean $master 是否主服务器
     * @return void
     */
    public function switchCollection($collection,$db='',$master=true){
        // 当前没有连接 则首先进行数据库连接
        if ( !$this->_linkID ) $this->initConnect($master);
        try{
            if(!empty($db)) { // 传人Db则切换数据库
                // 当前MongoDb对象
                $this->_dbName  =  $db;
                $this->_mongo = $this->_linkID->selectDb($db);
            }
            // 当前MongoCollection对象
            if($this->config['debug']) {
                $this->queryStr   =  $this->_dbName.'.getCollection('.$collection.')';
            }
            if($this->_collectionName != $collection) {
                $this->queryTimes++;
                N('db_query',1); // 兼容代码
                $this->debug(true);
                $this->_collection =  $this->_mongo->selectCollection($collection);
                $this->debug(false);
                $this->_collectionName  = $collection; // 记录当前Collection名称
            }
        }catch (MongoException $e){
            E($e->getMessage());
        }
    }
}