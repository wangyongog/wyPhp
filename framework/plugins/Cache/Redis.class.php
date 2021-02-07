<?php
namespace WyPhp\Cache;
use WyPhp;
use WyPhp\CF;

/**
 * 使用Redis作为Cache
 * Class Redis
 *
 * @package Swoole\Cache
 */
class Redis extends WyPhp\Cache{
    protected $redis;
    protected static $redis_link;
    //自定义前缀
    private $_prefix = 'wy_';
    //redis主机标示
    private $_redis_id;

    function __construct(array $config =[]){
        if(!class_exists('redis', false)){
            WyPhp\Error::error('not drive :redis');
        }
        $this->config = CF('redis');
        $this->_redis_id = isset($config['hostId']) ? $config['hostId'] : $this->config['hostId'];
        $this->redis = self::$redis_link[$this->_redis_id];
        if($this->redis == null){
            $this->config = [
                'host' =>$this->config['host'] ? $this->config['host'] : '127.0.0.1', ///tmp/redis.sock
                'port' =>$this->config['port'] ? $this->config['port'] : 6379,
                'timeout' =>$this->config['timeout'] ? $this->config['timeout'] : 300,////连接超时时间，redis配置文件中默认为300秒
                'persistent' =>$this->config['persistent'] ? $this->config['persistent'] : false,//是否长链接
                'prefix' =>$this->config['prefix'] ? $this->config['prefix'] : $this->_prefix,
                'expire' =>$this->config['expire'] ? $this->config['expire'] : 7200,
                'password' =>$this->config['password'] ? $this->config['password'] : '',//redis密码
                'dbindex' =>$this->config['dbindex'] ? $this->config['dbindex'] : 0,//选择redis数据库
            ];
            if (!empty($config)) {
                $this->config = array_merge($this->config, $config);
            }
            self::$redis_link[$this->_redis_id] = new \Redis;
            $this->redis = self::$redis_link[$this->_redis_id];
            $this->config['persistent'] ? $this->redis->pconnect($this->config['host'], $this->config['port'], $this->config['timeout']) : $this->redis->connect($this->config['host'], $this->config['port']);
            //连接通后的数据库选择和密码验证操作
            $this->redis->select($this->config['dbindex']);
            if($this->config['password']){
                $this->redis->auth($this->config['password']);
            }
        }
    }

    /**
     * 设置缓存
     * @access public
     * @param string $key 缓存变量名
     * @param mixed $value  存储数据
     * @param integer $expire  有效时间（秒）
     * @return boolean
     */
    function set($key, $value, $expire = null){
        if(is_null($expire)) {
            $expire = $this->config['expire'];
        }
        $key = $this->config['prefix'].$key;
        //对数组/对象数据进行缓存处理，保证数据完整性
        $value  = is_object($value) || is_array($value) ? json_encode($value) : $value;
        if($expire >0) {
            return $this->redis->setex($key, $expire, $value);
        }
        return $this->redis->set($key, $value);
    }
    /**
     * 设置多个值
     * @param array $keyArray KEY名称
     * @param string|array $value 获取得到的数据
     * @param int $timeOut 时间
     */
    public function sets($keyArray, $expire =null) {
        if (is_array($keyArray)) {
            $expire = is_null($expire) ? $this->config['expire'] : $expire;
            if ($expire > 0) {
                foreach ($keyArray as $key => $value) {
                    $key = $this->config['prefix'].$key;
                    $value = is_object($value) || is_array($value) ? json_encode($value) : $value;
                    $this->redis->setex($key, $expire, $value);
                }
            }
        }
    }
    /**
     * 获取缓存值
     * @param $key
     * @return mixed
     */
    public function get($key){
        if(!$this->isExists($key)){
            return '';
        }
        $value = $this->redis->get($this->config['prefix'].$key);
        $jsonData = json_decode($value, true);
        return is_null($jsonData) ? $value : $jsonData;
    }

    /**
     * 返回当前数据库key数量
     */
    public function dbSize(){
        return $this->redis->dbSize();
    }

    /**
     * 设定一个key什么时候过期，time为一个时间戳
     * @param $key
     * @param $time
     * @return mixed
     */
    public function exprieAt($key, $time){
        return $this->redis->expireAt($this->config['prefix'].$key, $time);
    }

    /**
     * 同时获取多个值
     * @param ayyay $keyArray 获key数值
     * @return
     */
    public function gets($keyArray) {
        if (is_array($keyArray)) {
            return $this->redis->mget($keyArray);
        }
    }

    /**
     * 返回一个key还有多久过期，单位秒
     * @param unknown $key
     * @return
     */
    public function ttl($key){
        return $this->redis->ttl($this->config['prefix'].$key);
    }
    /**
     * 删除缓存值
     * @param $key
     * @return bool
     */
    function delete($key){
        return $this->redis->del($this->config['prefix'].$key);
    }
    /**
     * 关闭
     */
    public function close(){
        $this->redis->close();
    }

    /**
     * 重命名- 当且仅当newkey不存在时，将key改为newkey ，当newkey存在时候会报错哦RENAME
     *  和 rename不一样，它是直接更新（存在的值也会直接更新）
     * @param string $Key KEY名称
     * @param string $newKey 新key名称
     * @return
     */
    public function updateName($key,$newKey){
        return $this->redis->RENAMENX($this->config['prefix'].$key,$newKey);
    }

    /**
     * 获取KEY存储的值类型
     * none(key不存在) int(0)  string(字符串) int(1)   list(列表) int(3)  set(集合) int(2)   zset(有序集) int(4)    hash(哈希表) int(5)
     * @param string $key KEY名称
     */
    public function dataType($key){
        return $this->redis->type($this->config['prefix'].$key);
    }

    /**
     * HASH类型
     * @param string $tableName 表名字key
     * @param string $key 字段名字
     * @param sting $value 值
     * @return
     */
    public function hset($tableName,$field,$value){
        return $this->redis->hset($tableName,$field,$value);
    }
    /**
     * 得到hash表中一个字段的值
     * @param string $key 缓存key
     * @param string  $field 字段
     * @return string|false
     */
    public function hget($key,$field){
        return $this->redis->hGet($this->config['prefix'].$key,$field);
    }
    /*
     * 构建一个集合(无序集合)
     * @param string $key 集合Y名称
     * @param string|array $value  值
     */
    public function sadd($key,$value){
        return $this->redis->sadd($this->config['prefix'].$key,$value);
    }
    /**
     * 构建一个集合(有序集合)
     * @param string $key 集合名称
     * @param string|array $value  值
     * @return int
     */
    public function zadd($key, $value){
        return $this->redis->zadd($this->config['prefix'].$key,$value);
    }

    /**
     * 返回集合中所有元素
     * @param unknown $key
     */
    public function sMembers($key){
        return $this->redis->sMembers($this->config['prefix'].$key);
    }

    /**
     * 在队列头部插入一个元素
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function lpush($key,$value){
        return $this->redis->lPush($this->config['prefix'].$key,$value);
    }
    /**
     * 在队列头插入一个元素 如果key不存在，什么也不做
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function lPushx($key,$value){
        return $this->redis->lPushx($this->config['prefix'].$key,$value);
    }
    /**
     * 构建一个列表(先进先去，类似队列)
     * @param sting $key KEY名称
     * @param string $value 值
     */
    public function rpush($key,$value){
        return $this->redis->rpush($this->config['prefix'].$key,$value);
    }

    /**
     * 取出队列信息
     * @param $key
     * @return mixed
     */
    public function lpop($key){
        return bccomp($this->lLen($key),0)!=1 ? '' : $this->redis->lpop($this->config['prefix'].$key);
    }
    /**
     * 在队列尾部插入一个元素 如果key不存在，什么也不做
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function rPushx($key,$value){
        return $this->redis->rPushx($this->config['prefix'].$key,$value);
    }
    /**
     * 判断key是否存在
     * @param string $key KEY名称
     */
    public function isExists($key){
        return $this->redis->exists($this->config['prefix'].$key);
    }
    /**
     * 返回队列长度
     * @param unknown $key
     */
    public function lLen($key){
        return $this->redis->lLen($this->config['prefix'].$key);
    }

    /**
     * 返回队列指定区间的元素
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     */
    public function lRange($key,$start,$end){
        return $this->redis->lrange($this->config['prefix'].$key,$start,$end);
    }
    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public function increment($key) {
        return $this->redis->incr($this->config['prefix'].$key);
    }

    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public function decrement($key) {
        return $this->redis->decr($this->config['prefix'].$key);
    }
    /**
     * 获取所有key
     */
    public function keys($key=''){
        $key = empty($key) ? '*' : $this->config['prefix'].$key;
        return $this->redis->keys($key);
    }
    /**
     * 清空所有数据
     */
    public function flushall(){
        return $this->redis->flushall();
    }
    /**
     * 返回redis对象
     * redis有非常多的操作方法，我们只封装了一部分
     * 拿着这个对象就可以直接调用redis自身方法
     * eg:$redis->redisOtherMethods()->keys('*a*')   keys方法没封
     */
    public function redisObj() {
        return $this->redis;
    }
    public function __destruct(){
        //$this->close();
    }
    /**
     * 清空当前数据库
     * @access public
     * @return boolean
     */
    public function clear() {
        return $this->redis->flushDB();
    }
    public function __call($method, $args){
        $args[0] = $this->_prefix.$args[0];
        //调用缓存类型自己的方法
        if(method_exists($this->redis, $method)){
            return call_user_func_array(array($this->redis, $method), $args);
        }else{
            WyPhp\Error::error('__CLASS__'.':'.$method);
            return;
        }
    }
}