<?php
namespace WyPhp;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/4
 * Time: 15:45
 */
include FWPATH . '/plugins/smarty/libs/Smarty.class.php';
class Template extends \Smarty{
    //缓存时间
    protected $cache_life = 3600;
    private static $_cache_data = '/data';

    function __construct(){
        parent::__construct();
        $this->template_dir = APPATH.'/templates';
        $this->compile_dir = ROOT. self::$_cache_data. APP_ROOT.'/templates_c'; //放置模板编译后的文件
        $this->cache_dir = ROOT. self::$_cache_data .APP_ROOT.'/cache'; //放置缓存文件
        $this->config_dir = ROOT. self::$_cache_data .'/data'.APP_ROOT.'/configs/';
        $this->caching = F('CACHING');
        $this->left_delimiter = '{';
        $this->right_delimiter = '}';
    }
    function __init(){
        $this->clear_all_assign();
    }

    /**
     * 开启缓存模式 并设置缓存时间
     * @param int $cache_life 缓存时间
     */
    function set_cache(){
        //$this->debugging = true;
        $this->caching = true;
    }
    /**
     * 输出模板
     * @param null $template 模板名
     * @param null $cache_id  指定一个缓存号
     * @param null $complile_id  指定一个编译号
     * @param null $parent
     */
    function render($template = null, $cache_id = null, $complile_id = null, $parent=null){
        $template = $template == null ? $this->parseTemplate() : $template;
        parent::display($template, $cache_id, $complile_id, $parent);
    }

    /**
     * 获取模版，赋值给一个变量
     * @param null $template
     * @param null $cache_id
     * @param null $complile_id
     * @param null $parent
     */
    public function fetch($template = null, $cache_id = null, $complile_id = null, $parent=null){
        $template = $template == null ? $this->parseTemplate() : $template;
        return parent::fetch($template, $cache_id, $complile_id, $parent);
    }
    /**
     * 生成静态页面
     * @param $template  文件地址
     * @param $filename  生成文件名
     * @param $path  生成路径
     * @return true | false
     */
    function craetHtml($template='', $filename='', $path = ''){
        $path = ROOT.'/'.F('CACHE_HTML').'/'. ($path ? $path : CONTROLLER);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $content = $this->fetch($template);
        file_put_contents($path . '/' . ($filename ? $filename:ACTION.F('URL_HTML_FIX')), $content);
    }
    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public function parseTemplate($template='') {
        // 如果模板文件名为空 按照默认规则定位
        $template = (is_array($this->template_dir) ? $this->template_dir[0] :$this->template_dir.'/') . CONTROLLER. '/' .ACTION . '.html' ;
        if(!is_file($template)){
            Error::debug(CONTROLLER. '/' .ACTION . '.html Template not find exist');
        }
        return $template;
    }
    /**
     * @param string $func
     * @param array $param
     * @return mixed
     */
    function __call($func, $param){
        return call_user_func_array(array($this, $func), $param);
    }
}