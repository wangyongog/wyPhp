<?php
namespace WyPhp;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/6
 * Time: 17:41
 *
 * 缓存管理类
 *
 */
abstract class Cache{
    protected $config = [];
    static $CacheLink = [];
    /**
     * 连接缓存
     * @access public
     * @param string $type 缓存类型
     * @param array $options  配置数组
     * @return object
     */
    static function connect($type='',$options=[]) {
        if(!isset(self::$CacheLink[$type])){
            if(empty($type)) $type = CF('CACHE_TYPE');
            $class = strpos($type,'\\') ? $type : 'WyPhp\\Cache\\'.ucwords(strtolower($type));
            if(!class_exists($class)){
                Error::error('not find '.$class);
            }
            self::$CacheLink[$type] = new $class($options);
        }
        return self::$CacheLink[$type];
    }
    /**
     * 设置缓存
     * @param $key
     * @param $value
     * @param $expire
     * @return bool
     */
    abstract function set($key, $value, $expire=0);
    /**
     * 获取缓存值
     * @param $key
     * @return mixed
     */
    abstract function get($key);
    /**
     * 删除缓存值
     * @param $key
     * @return bool
     */
    abstract function delete($key);
    public function __get($name) {
        return $this->get($name);
    }

    public function __set($name,$value) {
        return $this->set($name,$value);
    }

    public function __unset($name) {
        $this->delete($name);
    }
    public function setOptions($name,$value) {
        $this->options[$name] = $value;
    }

    public function getOptions($name) {
        return $this->options[$name];
    }
    /*public function __call($method, $args){
        //调用缓存类型自己的方法
        if(method_exists($this->handler, $method)){
            return call_user_func_array(array($this->handler, $method), $args);
        }else{
            Error::error('__CLASS__'.':'.$method);
            return;
        }
    }*/
}