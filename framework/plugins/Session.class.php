<?php
namespace WyPhp;
/**
 * Session会话控制类
 * Created by PhpStorm.
 * User: Administrator
 */
class Session{
    protected $cache;
    protected $_cache = [];
    protected $config;
    /**
     * 连接选项
     * @param null $type 选择缓存方式
     */
    public function __construct($type = null,$options=[]) {
        $type = !$type ? CF('SESSION_CACHE') : $type;
        if($type){
            if( empty($this->_cache[$type])){
                $this->config['sess_domain'] = CF('COOKIE_DOMAIN') ? CF('COOKIE_DOMAIN') : '';
                /*$var_session_id = F('SESSION_ID');
                if($var_session_id){
                    session_id($var_session_id);
                }*/
                $this->config['expire'] = CF('LIFT_TIME') ? CF('LIFT_TIME') : 7200;
                $this->config['prefix'] = CF('SESSION_PREFIX') ? CF('SESSION_PREFIX') : '';
                $this->config['sessionTable'] = CF('SESSION_TABLE') ? CF('SESSION_TABLE') : '';
                $this->config = array_merge($this->config, $options);
                $class = strpos($type,'\\') ? $type : 'WyPhp\\Session\\'.ucwords(strtolower($type));
                if(class_exists($class)){
                    $this->_cache[$type] = new $class($this->config);
                } else{
                    $this->_cache[$type] = null;
                    Error::error('not find '.'WyPhp\\Session\\'.ucwords(strtolower($type)));
                }
            }
            $this->cache = $this->_cache[$type];
            $this->_init();
        }
        //默认PHP内建的SESSION
        if (!session_id()) session_start();
    }
    /**
     * 初始化Session，配置Session
     * @param   NULL
     * @return  Bool  true/FALSE
     */
    private function _init(){
        if(isset($this->config['sess_name']))  session_name($this->config['sess_name']);
        if(isset($this->config['sess_path']))  session_save_path($this->config['sess_path']);
        //不使用 GET/POST 变量方式
        ini_set('session.use_trans_sid', 0);
        //设置垃圾回收最大生存时间
        if($this->config['expire']){
            ini_set('session.gc_maxlifetime', $this->config['expire']);
            ini_set('session.cookie_lifetime', $this->config['expire']);
        }
        //使用 COOKIE 保存 SESSION ID 的方式
        ini_set('session.use_cookies', 1);
        ini_set('session.cookie_path', '/');
        //多主机共享保存 SESSION ID 的 COOKIE
        if($this->config['sess_domain']) ini_set('session.cookie_domain', $this->config['sess_domain']);
        //将 session.save_handler 设置为 user，而不是默认的 files
        ini_set('session.save_handler','user');
        //session_module_name('user');
        //定义 SESSION 各项操作所对应的方法名
        //session_set_save_handler($this->cache, true);  //extends \SessionHandler//这行和下面等效
        session_set_save_handler(
            array($this->cache, 'open'),
            array($this->cache, 'close'),
            array($this->cache, 'read'),
            array($this->cache, 'write'),
            array($this->cache, 'destroy'),
            array($this->cache, 'gc'));
        register_shutdown_function('session_write_close');
    }
}
