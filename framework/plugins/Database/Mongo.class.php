<?php
namespace WyPhp\Database;

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
            $this->ExceptionLog('mongoClient NOT Driver');
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
                $this->ExceptionLog($e->getmessage());
            }
        }
        return $this->linkID[$linkNum];
    }
}