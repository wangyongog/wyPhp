<?php
namespace WyPhp\Session;
use WyPhp\DB;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/29
 * Time: 16:59
 */
class Dbsession extends \SessionHandler{
    protected $sessionTable = 'session';
    protected $config = [
        'sessionTable' =>'session', //session保存的数据库名
        'expire' =>7200
    ];
    /*$create_sql = "CREATE TABLE `nf_session` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`sid` VARCHAR(300) NOT NULL DEFAULT '',
	`value` TEXT NOT NULL,
	`expire` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `sid` (`sid`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
;";
        */
    //sid 为 SESSION ID，expiry 为 SESSION 过期时间，value 用于保存 SESSION数据
    function __construct($config = []){
        $this->config['sessionTable'] = isset($config['sessionTable']) ? $config['sessionTable'] : F('SESSION_TABLE');
        $this->config = array_merge($this->config, $config);

    }
    function open($save_path, $session_name){
        return true;
    }
    function close(){
        $this->gc();
        DB::close();
        return true;
    }
    function read($sid){
        $condition['expire'] = ['gt', TIMESTAMP];
        $result = DB::fetch_first($this->config['sessionTable'],'`value`,sid', 'sid="'.$sid.'"');
        return isset($result['value']) ? $result['value'] : '';
    }
    function write($sid, $value){
        $condition['sid'] = $sid;
        $data['value'] = $value;
        $data['sid'] = $sid;
        $data['expire'] = TIMESTAMP + $this->config['expire'];
        if(DB::insert($this->config['sessionTable'], $data,true)){
            return true;
        }
        return false;
    }
    function destroy($sid){
        $condition['`sid`'] = $sid;
        return DB::delete($this->config['sessionTable'], $condition);
    }
    function gc($maxlifetime=0){
        $condition['expire'] = ['lt', TIMESTAMP];
        return DB::delete($this->config['sessionTable'], $condition);
    }
    public function __destruct(){

    }
}