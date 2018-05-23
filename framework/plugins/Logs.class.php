<?php
namespace WyPhp;
class Logs{
    // 日志级别 从上到下，由低到高
    const EMERG = 'EMERG';  // 严重错误: 导致系统崩溃无法使用
    const ALERT = 'ALERT';  // 警戒性错误: 必须被立即修改的错误
    const CRIT = 'CRIT';  // 临界值错误: 超过临界值的错误，例如一天24小时，而输入的是25小时这样
    const ERR = 'ERR';  // 一般错误: 一般性错误
    const WARN = 'WARN';  // 警告性错误: 需要发出警告的错误
    const NOTICE = 'NOTIC';  // 通知: 程序可以运行但是还不够完美的错误
    const INFO = 'INFO';  // 信息: 程序输出信息
    const DEBUG = 'DEBUG';  // 调试: 调试信息
    const SQL = 'SQL';  // SQL：SQL语句 注意只在调试模式开启时有效
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
        $level = $level ? $level : self::ERR;
        $message = is_array($message) ? json_encode($message) : $message;
        self::$log[] = $level.':'. $message.'\r\n';
    }
    /**
     * 日志保存
     * @static
     * @access public
     * @param integer $type 日志记录方式
     * @param string $destination  写入目标
     * @return void
     */
    public static function save($type='',$destination='') {
        if(empty(self::$log)) return ;
        if(!self::$storage){
            $type = $type ?: CF::get('ERROR_TYPE');
            $class  =   'WyPhp\\Logs\\'. ucfirst($type);
            self::$storage = new $class();
        }
        $message = implode('',self::$log);
        self::$storage->write($message,$destination);
        // 保存后清空日志缓存
        self::$log = array();
    }
}