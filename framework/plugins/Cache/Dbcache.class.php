<?php
namespace WyPhp\Cache;
use WyPhp;
use WyPhp\DB;
/**
 * 数据库缓存
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/22
 * Time: 17:15
 */
class DBCache extends WyPhp\Cache{
    protected $options = [];
    function __construct($options=[]){
        if(empty($options)) {
            $options = [
                'table' => WyPhp\CF::get('DATA_CACHE_TABLE')
            ];
        }
        $this->options = $options;
        /*$create_sql = "CREATE TABLE `cache_data` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `key` VARCHAR( 128 ) NOT NULL ,
            `value` TEXT NOT NULL ,
            `sid` VARCHAR(10) NOT NULL ,
            `expire` INT NOT NULL ,
            INDEX ( `key` )
            ) ENGINE = MyISAM;";
        DB::query($create_sql);exit;*/
    }

    /**
     * 获取缓存
     * @param $key
     * @return string
     */
    function get($key){
        $condition['`key`'] = $key;
        $condition['expire'] = ['gt', TIMESTAMP];
        $result = DB::fetch_first($this->options['table'],'value,sid,`key`', $condition);
        if(!empty($result['value'])){
            $jsonData = unserialize( $result['value']);
            return empty($jsonData) ? $result['value'] : $jsonData;
        }
        return '';
    }

    /**
     * 设置缓存
     * @param $key
     * @param $value
     * @param int $expire
     * @return mixed
     */
    function set($key, $value, $expire = 0){
        $condition['`key`'] = $key;
        $data['value'] = is_array($value) ? serialize($value) : $value;
        $data['sid'] = '';
        $expire = $expire ? $expire : WyPhp\CF::get('DATA_CACHE_TIME');
        $data['expire'] = $expire==0 ? (3600*24*360000)+ TIMESTAMP : TIMESTAMP+$expire;
        $result = DB::result_first($this->options['table'],'id', $condition);
        if($result){
            return DB::update($this->options['table'], $data, $condition);
        }
        $data['`key`'] = $key;
        return DB::insert($this->options['table'], $data);
    }

    /**
     * 删除缓存
     * @param $key
     * @return mixed
     */
    function delete($key){
        $condition['`key`'] = $key;
        return DB::delete($this->options['table'], $condition);
    }
    /**
     * 清除过期缓存
     * @access public
     * @return boolean
     */
    public function gc() {
        $condition['expire'] = ['lt', TIMESTAMP];
        return DB::delete($this->options['table'], $condition);
    }
    /**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public function clear() {
        return DB::delete($this->options['table']);
    }
}