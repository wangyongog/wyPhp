<?php
namespace WyPhp;
class Logs{
    // 日志信息
    static protected $log  = [];
    // 日志存储
    static protected $storage = null;
    /**
     * 记录日志 并且会过滤未经设置的级别
     * @static
     * @access public
     * @param string $message 日志信息
     * @param string $level  日志级别
     * @param boolean $record  是否强制记录
     * @return void
     */
    static function record($message, $level='') {
        $level = $level ? $level : 'file';
        $message = is_array($message) ? json_encode($message) : $message;
        //self::$log[] = $level.' : '. $message;
        return $message;
    }
    /**
     * 日志保存
     * @static
     * @access public
     * @param integer $type 日志记录方式
     * @return void
     */
    public static function save($msg ,$type='file') {
        $message = self::record($msg, $type);
        if(!self::$storage){
            $log_type = CF('ERROR_TYPE');
            $class  =   'WyPhp\\Logs\\'. ucfirst($log_type);
            self::$storage = new $class();
        }
        //$message = implode('',self::$log);
        self::$storage->write($message,$type);
        // 保存后清空日志缓存
        //self::$log = [];
    }
}