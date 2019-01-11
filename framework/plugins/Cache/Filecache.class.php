<?php
namespace WyPhp\Cache;
use WyPhp;

/**
 * 文件缓存类，提供类似memcache的接口
 * 警告：此类仅用于测试，不作为生产环境的代码，请使用Key-Value缓存系列！
 * @author Tianfeng.Han
 * @package Swoole
 * @subpackage cache
 */
class FileCache extends WyPhp\Cache{
    protected $config;
	function __construct($config){
        if(empty($config)){
            $this->config['cache_dir'] =  ROOT.CF('CACHE_PATH');
            $this->config['ext'] = '_cache.php';
            if (!is_dir($this->config['cache_dir'])) {
                mkdir($this->config['cache_dir'], 0755, true);
            }
        }
        $this->config = array_merge($this->config, $config) ;
    }

    /**
     * 获取文件名
     * @param $key
     * @return string
     */
    protected function getFileName($key){
        $file = $this->config['cache_dir'] .'/'.date('Ym') .'/' . trim(str_replace('_', '/', $key), '/').'_'.md5($key).$this->config['ext'];
        $dir = dirname($file);
        if(!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return $file;
    }
    /**
     * 设置缓存
     * @param $key
     * @param $value
     * @param int $expire
     * @return mixed
     */
    function set($key, $value, $expire=0){
        $file = $this->getFileName($key);
        $data['value'] = $value;
        $data['sid'] = '';
        $expire = $expire ? $expire : CF('DATA_CACHE_TIME');
        $expire and $data['timeout'] = $expire + TIMESTAMP;
        return file_put_contents($file, json_encode($data));
    }
    /**
     * 获取缓存
     * @param $key
     * @return string
     */
	function get($key){
        $file = $this->getFileName($key);
        if(!is_file($file)) return false;
        $data = file_get_contents($file);
        if(empty($data)){
            $this->delete($key);
            return false;
        }
        $data = json_decode($data,true);
        if (empty($data) or !isset($data['value'])) {
            return false;
        }
        //已过期
        if (isset($data['timeout']) && $data['timeout'] < TIMESTAMP) {
            $this->delete($key);
            return false;
        }
        return $data['value'];
	}
    /**
     * 删除缓存
     * @param $key
     * @return mixed
     */
	function delete($key){
        $file = $this->getFileName($key);
        is_file($file) and unlink($file);
	}
    /**
     * 清除过期缓存
     * @access public
     * @return boolean
     */
    public function gc() {

    }
    /**
     * 清除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function clear() {
        $path = $this->config['cache_dir'];
        $files = scandir($path);
        if($files){
            foreach($files as $file){
                if ($file != '.' && $file != '..' && is_dir($path.$file) ){
                    array_map( 'unlink', glob( $path.$file.'/*.*' ) );
                }elseif(is_file($path.$file)){
                    unlink( $path . $file );
                }
            }
            return true;
        }
        return false;
    }
}