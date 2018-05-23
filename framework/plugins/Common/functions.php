<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/3
 * Time: 10:23
 */
/**
 * cookie设置
 * @param $key 设置的cookie名
 * @param $value 设置的cookie值
 * @param int|设置的过期时间 $life 设置的过期时间：为整型，单位秒 如60表示60秒后过期
 * @param string|设置的cookie作用路径 $path 设置的cookie作用路径
 * @param string|设置的cookie作用域名 $domain 设置的cookie作用域名
 * @param bool $secure 是否仅通过安全的 HTTPS 连接传送。当设成 TRUE 时，cookie 仅在安全的连接中被设置。默认值为FALSE
 */
function Cookie($key='', $value='', $life = 0, $path = '/', $domain = '',$secure=false,$httponly=false) {
    $domain = $domain ? $domain : F('COOKIE_DOMAIN');
    $life = $life ? $life : F('LIFT_TIME');
    if($httponly){
        ini_set('session.cookie_httponly', 1);
    }
    $key = F('COOKIE_HASH') === true ? mcrypt($key) : $key;
    if($value){
        $value = F('COOKIE_HASH') ==true ? mcrypt($value) : $value;
        setcookie($key, $value, $life ? (TIMESTAMP + $life) : 0, $path, $domain,$secure,$httponly);
        $_COOKIE[$key] = $value;
    }elseif (is_null($value)){
        setcookie($key, '', TIMESTAMP - 3600, $path, $domain,$secure,$httponly);
        unset($_COOKIE[$key]);
    }elseif ($value === ''){
        $value = $_COOKIE[$key];
        return F('COOKIE_HASH') === true ? mcrypt($value, 'DECODE') : $value;
    }
}

/**
 * @param string $key
 * @param string $value
 * @param null $type  存储类型
 * @return bool|null
 */
function session($key='', $value='', $type=NULL,$options=[]){
    if(!$key) return false;
    NEW \WyPhp\Session();
    if(!empty($value) ){
        $_SESSION[$key] = $value;
        return true;
    }
    if($value ===''){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    if($value === null){
        unset($_SESSION[$key]);
    }
}
function I($key, $type = 'string',$default = '',$filter=''){
    if(!isset(\WyPhp\Filter::$gp[$key])){
       return $default;
    }
    /*if($filter && function_exists($filter)){
         return is_array(\WyPhp\Filter::$gp[$key]) ? array_map_recursive($filter,\WyPhp\Filter::$gp[$key]) : $filter(\WyPhp\Filter::$gp[$key]);
    }*/
    return \WyPhp\Sutil::getStr(\WyPhp\Filter::$gp[$key], $type ,$default);
}
function array_map_recursive($filter, $data) {
    $result = array();
    foreach ($data as $key => $val) {
        $result[$key] = is_array($val)
            ? array_map_recursive($filter, $val)
            : call_user_func($filter, $val);
    }
    return $result;
}
/**
 * 获取配置信息
 * @param $name
 * @return array|mixed|null
 */
function F($name){
    return \WyPhp\CF::get($name);
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
    $name = ucfirst($name);
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
        $model = new WyPhp\Model(basename($name));
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
 * 函数：格式化字节大小
 * @param  number $size 字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = ''){
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) {
        $size /= 1024;
    }
    return round($size, 2) . $delimiter . $units[$i];
}
/**
 * 递归删除缓存信息
 * @param $dirname
 * @return bool
 */
function rmdirr($dirname){
    if (!file_exists($dirname)) {
        return false;
    }
    if (is_file($dirname) || is_link($dirname)) {
        return unlink($dirname);
    }
    $dir = dir($dirname);
    if ($dir) {
        while (false !== $entry = $dir->read()) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            //递归
            rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
        }
    }
    $dir->close();
    return rmdir($dirname);
}

/**
 * 验证手机号是否正确
 * @param $mobile
 * @return bool
 */
function isMobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
}
/**
 * 生成唯一订单号
 * @return string
 */
function creatOrderId(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).random(3,1);
}
/**
 * @param array $user
 * @param int $len
 * @return string
 */
function formhash(){
    $user = APP::$user;
    $uid =isset($user['uid']) ? $user['uid'] : '';
    $hash = isset($user['hash']) ? $user['hash'] : '';
    $skey = mcrypt('hashCode'.$uid);
    $hashCode = session($skey);
    if(empty($hashCode) ){
        $hashCode = random(20);
        session($skey, $hashCode);
    }
    return substr(md5( $hashCode.$hash . $uid  . substr(F('AUTOKEY'),5,6) ), 8, 10);
}
function post($url, $param=array()){
    /*if(!is_array($param)){
        throw new Exception("参数必须为array");
    }*/
    $httph =curl_init($url);
    curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($httph,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($httph, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);//"Mozilla/5.0 (compatible; MSIE 6.1; Windows NT 5.0)"
    /*if ($param) {
        //$param = is_array($param) ? http_build_query($param) : $param;
        curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式
        curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
    }*/
    curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式
    curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
    curl_setopt($httph, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($param),
            'Accept: application/json, text/javascript, */*; q=0.01'
        )
    );
    curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($httph, CURLOPT_HEADER, 0);
    $rst = curl_exec($httph);
    if (curl_errno($httph)) {
        curl_close($httph);
        return false;
    }
    curl_close($httph);
    return $rst;
}
/**
 * @param string $formhash
 * @return bool
 */
function check_formhash($formhash=''){
    /*if(!$formhash){
        return false;
    }*/
    $formhash = I('formhash') ? I('formhash') : $_SERVER['HTTP_X_CSRF_TOKEN'];
    $user = APP::$user;
    $uid =isset($user['uid']) ? $user['uid'] : '';
    $hash = isset($user['hash']) ? $user['hash'] : '';
    $skey = mcrypt('hashCode'.$uid);
    if($formhash == substr(md5( session($skey).$hash . $uid  . substr(F('AUTOKEY'),5,6)), 8, 10)){
        IS_AJAX or session($skey, null);
        return true;
    }
    session($skey, null);
    return false;
}
/**
 * 创建Token
 * @param $TokenId
 * @param string $TokenKey
 * @return string
 */
function creatToken($TokenId=0, $TokenKey = '', $len=8){
    $TokenKey = $TokenKey ? $TokenKey.substr(F('AUTOKEY'),4,12) : substr(F('AUTOKEY'),4,12) ;
    return substr(md5($TokenId. $TokenKey),5, $len) ;
}
/**
 * 产生随机数
 * @param int|产生随机数长度 $length 产生随机数长度
 * @param int|返回字符串类型 $type 返回字符串类型
 * @param bool|是否去除0 $noO 是否去除0
 * @param string|是否由前缀 $hash 是否由前缀，默认为空. 如:$hash = 'zz-'  结果zz-823klis
 * @return 随机字符串 $type = 0：数字+字母
 */
function random($length =6, $type = 0,$noO = false, $hash = '') {
    if ($type == 0) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    } else if ($type == 1) {
        $chars = '0123456789';
    } else if ($type == 2) {
        $chars = 'abcdefghijklmnopqrstuvwxyz';
    } elseif ($type == 3) {
        $chars = '0123456789abcdefghijkmnpqrstuvwxyz';
    } elseif ($type == 4) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    }
    $noO and $chars = str_replace('0','', $chars);
    $max = strlen($chars) - 1;
    mt_srand((double) microtime() * 1000000);
    for ($i = 0; $i < $length; $i ++) {
        $hash .= $chars [mt_rand(0, $max)];
    }
    return $hash;
}
/**
 * 二位数据排序
 * @param $arrays
 * @param $sort_key
 * @param int $sort_order
 * @param int $sort_type
 * @return array|bool
 */
function my_sort($arrays, $sort_key, $sort_order=SORT_ASC, $sort_type=SORT_NUMERIC ){//SORT_DESC
    if(is_array($arrays)){
        foreach ($arrays as $array){
            if(is_array($array)){
                $key_arrays[] = $array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
    return $arrays;
}
/**
 * 创建目录
 * @param $path  创建的目录的名称
 * @param int $mode 规定权限
 * @param bool $recursive 是否设置递归模式
 */
function cmkdir($path, $mode=0775, $recursive =true){
    if (!is_dir($path)) {
        mkdir($path, $mode, $recursive);
    }
}

/**
 * 加密与解密字串
 * @param array $value 要加解密字符串
 * @param $operation  ENCODE 加密，
 * @param $skey 加密串
 * @return string
 */
function mcrypt($value, $operation = 'ENCODE', $skey = '') {
    if (empty($value)) {
        return false;
    }
    $skey = $skey ? $skey : substr(F('AUTOKEY'),4,10);
    if ($operation == 'ENCODE') {
        $sResult = '';
        for ($i = 0; $i < strlen($value); $i++) {
            $sChar = substr($value, $i, 1);
            $skeyChar = substr($skey, ($i % strlen($skey)) - 1, 1);
            $sChar = chr(ord($sChar) + ord($skeyChar));
            $sResult .= $sChar;
        }
        $sBase64 = base64_encode($sResult);
        return str_replace('=', '', strtr($sBase64, '+/', '-_'));
    } else {
        $sResult = '';
        $value = strtr($value, '-_', '+/');
        $value = base64_decode($value . '==');
        for ($i = 0; $i < strlen($value); $i++) {
            $sChar = substr($value, $i, 1);
            $skeyChar = substr($skey, ($i % strlen($skey)) - 1, 1);
            $sChar = chr(ord($sChar) - ord($skeyChar));
            $sResult .= $sChar;
        }
        return $sResult;
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
        $suffix = $suffix===true ? F('URL_HTML_FIX') : $suffix;
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
        if(is_array($options)) {
            $expire = isset($options['expire']) ? $options['expire'] : NULL;
        }else{
            $expire = is_numeric($options) ? $options : NULL;
        }
        return $cache->set($name, $value, $expire);
    }
}
function redirect($url){
    header('Location: ' . $url);
    edie();
}
/**
 * 判断是否SSL协议
 * @return boolean
 */
function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    }elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function getIP($type = false,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}