<?php
function G($key, $type = 'string',$default = '',$filter=''){
    if(!isset(\WyPhp\Filter::$gp[$key])){
        return $default;
    }
    if($filter && function_exists($filter)){
         return is_array(\WyPhp\Filter::$gp[$key]) ? array_map_recursive($filter,\WyPhp\Filter::$gp[$key]) : $filter(\WyPhp\Filter::$gp[$key]);
    }
    return \WyPhp\Filter::getStr(\WyPhp\Filter::$gp[$key], $type ,$default);
}

/**
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
function CF($name=null, $value=null,$default=null) {
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) {
        return $_config;
    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            //$name = strtoupper($name);
            if (is_null($value)){
                return isset($_config[$name]) ? $_config[$name] : $default;
            }
            $_config[$name] = $value;
            return null;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value)){
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        }
        $_config[$name[0]][$name[1]] = $value;
        return null;
    }
    // 批量设置
    if (is_array($name)){
        $_config = array_merge($_config, $name);
        return null;
    }
    return null; // 避免非法参数
}
/**
 * 加载配置文件 支持格式转换 仅支持一级配置
 * @param string $file 配置文件名
 * @param string $parse 配置解析方法 有些格式需要用户自己解析
 * @return array
 */
function load_config($file,$parse=''){
    try{
        $ext  = pathinfo($file,PATHINFO_EXTENSION);
        switch($ext){
            case 'php':
                return include $file;
            case 'ini':
                return parse_ini_file($file,true);
            case 'yaml':
                return yaml_parse_file($file);
            case 'xml':
                return (array)simplexml_load_file($file);
            case 'json':
                return json_decode(file_get_contents($file), true);
            default:
                if(function_exists($parse)){
                    return $parse($file);
                }
        }
    }catch (\Exception $e){
        throw new \Exception($e->getMessage());
    }

}
/**
 * D函数用于实例化模型类 格式 [资源://][模块/]模型
 * @param string $name 资源地址
 * @param string $layer 模型层名称
 * @return Model
 */
function D($name='',$layer='') {
    if(empty($name)) return false;
    static $_model = [];
    $layer = $layer ? : 'Model';
    //$name = ucfirst($name);
    if(isset($_model[$name.$layer]))
        return $_model[$name.$layer];
    $class = parse_res_name($name,$layer);
    if(class_exists($class)) {
        $model = new $class(basename($name));
    }elseif(false === strpos($name,'/')){
        // 自动加载公共模块下面的模型
        $class = '\\Common\\'.$layer.'\\'.$name.$layer;
        $model = class_exists($class)? new $class($name) : '';
    }else {
        \WyPhp\Error::debug('D方法实例化没找到模型类'.$class);
    }
    $_model[$name.$layer] = $model;
    return $model;
}
/**
 * 解析资源地址并导入类库文件
 * 例如 module/controller addon://module/behavior
 * @param string $name 资源地址 格式：[扩展://][模块/]资源名
 * @param string $layer 分层名称
 * @return string
 */
function parse_res_name($name,$layer,$level=1){
    if(strpos($name,'://')) {// 指定扩展资源
        list($extend,$name)  =   explode('://',$name);
    }else{
        $extend  =   '';
    }
    if(strpos($name,'/') && substr_count($name, '/')>=$level){ // 指定模块
        list($module,$name) =  explode('/',$name,2);
    }else{
        $module = 'Common';
        if(!is_file(ROOT.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$layer.DIRECTORY_SEPARATOR.$name.$layer. '.class.php')){
            $module = end( explode(DIRECTORY_SEPARATOR,$_SERVER['DOCUMENT_ROOT']));
        }
    }
    $array  =   explode('/',$name);
    $class  =   $module.'\\'.$layer;
    foreach($array as $name){
        $class  .=   '\\'.parse_name($name, 1);
    }
    // 导入资源类库
    if($extend){ // 扩展资源
        $class      =   $extend.'\\'.$class;
    }
    return $class.$layer;
}
/**
 * 字符串命名风格转换
 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
 * @param string $name 字符串
 * @param integer $type 转换类型
 * @return string
 */
function parse_name($name, $type=0) {
    if ($type) {
        return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function($match){return strtoupper($match[1]);}, $name));
    } else {
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}

/**
 * URL组装 支持不同URL模式
 * @param string $url URL表达式，格式：'[模块/控制器/操作#锚点@域名]?参数1=值1&参数2=值2...'
 * @param string|array $vars 传入的参数，支持数组和字符串
 * @param string|boolean $suffix 伪静态后缀，默认为true表示获取配置值
 * @param boolean $domain 是否显示域名
 * @return string
 */
function U($url='', $vars='', $suffix=true, $domain=true){
    // 解析URL
    $info = parse_url($url);
    $url = !empty($info['path']) ? $info['path'] : ACTION;
    if($suffix) {
        $suffix = $suffix===true ? CF('URL_HTML_FIX') : $suffix;
        if($suffix && '/' != substr($url,-1)){
            $url  .=  '.'.ltrim($suffix,'.');
        }
    }
    $url = strstr($url,'/',true) ? '/'.$url: $url;
    // 解析参数
    if(is_string($vars)) { // aaa=1&bbb=2 转换成数组
        parse_str($vars,$vars);
    }elseif(!is_array($vars)){
        $vars = array();
    }
    if(isset($info['query'])) { // 解析地址里面参数 合并到vars
        parse_str($info['query'],$params);
        $vars = array_merge($params,$vars);
    }
    if(!empty($vars)) {
        $vars = http_build_query($vars);
        $url .= '?'.$vars;
    }
    if($domain) {
        $url   =  (is_ssl()?'https://':'http://').$_SERVER['HTTP_HOST'].$url;
    }
    return $url;
}
/**
 * 缓存管理
 * @param mixed $name 缓存名称，如果为数组表示进行缓存设置
 * @param mixed $value 缓存值
 * @param mixed $options 缓存参数
 * @return mixed
 */
function S($name, $value='',$options=null) {
    static $cache = '';
    if(is_array($options)){
        // 缓存操作的同时初始化
        $type = isset($options['type']) ? $options['type'] : '';
        $cache = WyPhp\Cache::connect($type,$options);
    }elseif(is_array($name)) { // 缓存初始化
        $type = isset($name['type']) ? $name['type'] : '';
        $cache = WyPhp\Cache::connect($type,$name);
        return $cache;
    }elseif(empty($cache)) { // 自动初始化
        $cache = WyPhp\Cache::connect();
    }
    if(''=== $value){ // 获取缓存
        return $cache->get($name);
    }elseif(is_null($value)) { // 删除缓存
        return $cache->delete($name);
    }else { // 缓存数据
        $expire = isset($options['expire']) ? $options['expire'] : $options;
        return $cache->set($name, $value, $expire);
    }
}
