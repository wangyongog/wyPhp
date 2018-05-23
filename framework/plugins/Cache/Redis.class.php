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
    //自定义前缀
    private $_prefix = '_';
    //redis主机标示
    private $_redis_id = 'master';
    function __construct(array $config =[]){
        if(!class_exists('redis', false)){
            WyPhp\Error::error('not drive :redis');
        }
        empty(CF::get('redis/host')) and CF::get('redis');
        if($this->redis == null){
            $this->config = [
                'host' =>CF::get('redis/host') ? CF::get('redis/host') : '127.0.0.1',
                'port' =>CF::get('redis/port') ? CF::get('redis/port') : 6379,
                'timeout' =>CF::get('redis/timeout') ? CF::get('redis/timeout') : false,
                'persistent' =>CF::get('redis/persistent') ? CF::get('redis/persistent') : false,
                'prefix' =>$this->_prefix,
                'expire' =>CF::get('redis/expire') ? CF::get('redis/expire') : 24*3600
            ];
            if (!empty($config)) {
                $this->config = array_merge($this->config, $config);
            }
            $connect = $this->config['persistent'] ? 'pconnect' : 'connect';
            $this->redis = new \Redis;
            $this->config['timeout'] === false ? $this->redis->$connect($this->config['host'], $this->config['port']) : $this->redis->$connect($this->config['host'], $this->config['port'], $this->config['timeout']);
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
            if(is_null($expire)) {
                $expire = $this->config['expire'];
            }
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
    function get($key){
        $value = $this->redis->get($this->config['prefix'].$key);
        $jsonData = json_decode($value, true);
        return is_null($jsonData) ? $value : $jsonData;
    }
    /**
     * 同时获取多个值
     * @param ayyay $keyArray 获key数值
     */
    public function gets($keyArray) {
        if (is_array($keyArray)) {
            return $this->redis->mget($keyArray);
        }
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
     */
    public function updateName($key,$newKey){
        return $this->redis->RENAMENX($key,$newKey);
    }

    /**
     * 获取KEY存储的值类型
     * none(key不存在) int(0)  string(字符串) int(1)   list(列表) int(3)  set(集合) int(2)   zset(有序集) int(4)    hash(哈希表) int(5)
     * @param string $key KEY名称
     */
    public function dataType($key){
        return $this->redis->type($key);
    }
    /**
     * HASH类型
     * @param string $tableName  表名字key
     * @param string $key            字段名字
     * @param sting $value          值
     */
    public function hset($tableName,$field,$value){
        return $this->redis->hset($tableName,$field,$value);
    }

    public function hget($tableName,$field){
        return $this->redis->hget($tableName,$field);
    }
    /*
     * 构建一个集合(无序集合)
     * @param string $key 集合Y名称
     * @param string|array $value  值
     */
    public function sadd($key,$value){
        return $this->redis->sadd($key,$value);
    }
    /**
     * 构建一个集合(有序集合)
     * @param string $key 集合名称
     * @param string|array $value  值
     * @return int
     */
    public function zadd($key, $value){
        return $this->redis->zadd($key,$value);
    }

    /**
     * 取集合对应元素
     * @param string $setName 集合名字
     */
    public function smembers($setName){
        return $this->redis->smembers($setName);
    }

    /**
     * 构建一个列表(先进后去，类似栈)
     * @param sting $key KEY名称
     * @param string $value 值
     */
    public function lpush($key,$value){
        //echo "$key - $value \n";
        return $this->redis->LPUSH($key,$value);
    }

    /**
     * 构建一个列表(先进先去，类似队列)
     * @param sting $key KEY名称
     * @param string $value 值
     */
    public function rpush($key,$value){
        //echo "$key - $value \n";
        return $this->redis->rpush($key,$value);
    }
    /**
     * 获取所有列表数据（从头到尾取）
     * @param sting $key KEY名称
     * @param int $head  开始
     * @param int $tail     结束
     */
    public function lranges($key,$head,$tail){
        return $this->redis->lrange($key,$head,$tail);
    }
    /**
     * 判断key是否存在
     * @param string $key KEY名称
     */
    public function isExists($key){
        return $this->redis->exists($key);
    }
    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public function increment($key) {
        return $this->redis->incr($key);
    }

    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public function decrement($key) {
        return $this->redis->decr($key);
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
        $this->close();
    }
    /**
     * 清除缓存
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