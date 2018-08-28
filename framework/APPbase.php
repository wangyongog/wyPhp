<?php
class APPbase{
    public static $app = [];     //应用名称
    protected static $_map = [];
    public static $domain = [];   // 域名
    public static $view = 'Index';
    public static $uid = 0; //用户UID
    public static $user = [];  //用户数据
    protected static $controller = 'main';
    static $sessid = '';//访问网站产生唯一ID
    static $appPath = 'app';
    public static $env = []; // 记录运行时间，内存
    static function run(){
        //header("Content-type:text/html;charset=utf-8");
        self::__init();
        define('NL', PHP_OS == 'WINNT' ? "\r\n" : "\n");
        define('TIMESTAMP', $_SERVER['REQUEST_TIME']);
        define('FWPATH', __DIR__);//框架目录
        define('ROOT', substr(__DIR__,0, -10));  //根目录
        define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        define('APPATH', realpath(self::$appPath));

        $temp_uri = urldecode($_SERVER['REQUEST_URI']);
        if (strpos($temp_uri, '<') !== false || strpos($temp_uri, '"') !== false){
            exit('Request Bad url');
        }
        //修正时区
        if (version_compare(PHP_VERSION, '5.1' ,'>')) {
            date_default_timezone_set('Asia/Shanghai');
        }
        if($_SERVER['SERVER_PORT'] == '443') define('HTTPS', true);
        define('APP_ROOT', strtolower(strrchr($_SERVER['DOCUMENT_ROOT'], '\\')) );
        //自动加载
        spl_autoload_register(array('APP', 'autoload'));
        //自定义错误和异常处理
        register_shutdown_function('WyPhp\Error::fatalError');
        //自定义的错误处理
        set_error_handler('WyPhp\Error::DiyError');
        //自定义异常处理
        set_exception_handler('WyPhp\Error::WebException');
        self::loadApi();
        define('DEBUG', F('DEBUG')); //是否开启错误调试，true开启，false关闭
        self::rules();
        WyPhp\Filter::loadGetPost();
        APP::runBefore();
        define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
        define('IS_GET', REQUEST_METHOD =='GET' ? true : false);
        define('IS_POST',REQUEST_METHOD =='POST' ? true : false);
        define('IS_PUT', REQUEST_METHOD =='PUT' ? true : false);
        define('IS_DELETE',REQUEST_METHOD =='DELETE' ? true : false);
        define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false);
        //启动
        self::initApp();
    }

    /**
     * 自动导入
     * @param $class
     * @return mixed
     */
    protected static function autoload($class){
        if(isset(self::$_map[$class])) {
            return include self::$_map[$class];
        }
        $path = FWPATH.'/plugins';
        if(false !== strpos($class, '\\')){
            $name = strstr($class, '\\', true);
            if('App' === $name){
                return self::require_cache(APPATH, $class);
            }
            if('Common' === $name){
                return self::require_cache(ROOT.'/'.$name, $class);
            }
            if(!in_array($name,['Common','WyPhp']) && substr($class,-5) =='Model'){
                return self::require_cache(APPATH, $class);
            }
            if(!in_array($name,['WyPhp'.'App']) && is_dir(FWPATH.'/plugins/'.$name)){
                // plugins目录下面的命名空间自动定位
                $path = FWPATH.'/plugins/'.$name;
                return self::require_cache($path, $class);
            }
            return self::require_cache($path, $class);
        }
        return false;
    }
    protected static function require_cache($path='', $class=''){
        $file = $path.strstr($class ,'\\'). '.class.php';
        $file = str_replace('\\', DIRECTORY_SEPARATOR,  $file) ;
        if(!is_file($file)){
            $file = ROOT.DIRECTORY_SEPARATOR. strtolower(strstr($class, '\\', true)).DIRECTORY_SEPARATOR.self::$appPath.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, strstr($class ,'\\')).'.class.php';
            if(!is_file($file)){
                WyPhp\Error::debug("file [$file] not exists");
            }
        }
        self::$_map[$class] = $file;
        require_once($file);
    }
    /**
     *加载公共函数或第三方类
     */
    protected static function loadApi(){
        // 加载核心方法或第三方类
        WyPhp\CF::get('configs');
        WyPhp\CF::get('db');
        WyPhp\CF::get('api');
        $mode = WyPhp\CF::get('core');
        if(!empty($mode)){
            foreach ($mode as $file){
                is_file($file) and include $file;
            }
        }
        if($configs = F('LOAD_CONFIG')){
            if(is_string($configs)) $configs =  explode(',',$configs);
                foreach ($configs as $key=>$config){
                    $file = is_file($config) ? $config : ROOT.'/config/'.$config.'.inc.php';
                    if(is_file($file)) {
                        WyPhp\CF::set($file);
                    }
                }
        }
    }
    /**
     * 启动应用
     * @return bool|mixed
     */
    protected static function initApp(){
        $url = parse_url($_SERVER['REQUEST_URI']);
        if(empty($url)){
            header('HTTP/1.1 404 Not Found');
            header('Status:404 Not Found');
            exit;
        }
        $url = trim($url['path'], '/');
        if($url){
            $url = str_replace(F('URL_HTML_FIX'), '', $url);
            $url = explode('/', $url, 3);
        }
        $controller = !isset(self::$app['c']) ? (isset($url[0]) ? $url[0] : self::$controller) : self::$app['c'];
        $view = !isset(self::$app['a']) ? (isset($url[1]) && !is_numeric($url[1]) ? $url[1] : self::$view) : self::$app['a'];
        define('ACTION', strtolower($view));
        define('CONTROLLER', strtolower($controller));
        $action = 'action'.ucfirst($view);
        if (!preg_match('/^[A-Za-z](\w)*$/', $controller)) {
            WyPhp\Error::error('file ['.$controller.'] not exists');
            //\WyPhp\Error::http_status();
        }
        if (!preg_match('/^[a-z0-9_]+$/i', $action)) {
            \WyPhp\Error::http_status();
        }
        $filePath = self::$appPath.'/Controller/'. CONTROLLER.'.page.php';

        //命名空间类
        $classname = '\\App\\Controller\\'. CONTROLLER;
        if (class_exists($classname, false)) {
            WyPhp\Error::error('class ['.$classname.'] not exists');
        }
        if(!is_file($filePath)){
            WyPhp\Error::error('file ['.$filePath.'] not exists');
        }
        //self::$app = $controller .'/'.$action;
        include (realpath($filePath));
        $classInstance = new $classname();
        if(!method_exists($classInstance, $action)){
            WyPhp\Error::debug("method[$action] not exists in class[$classname]");
            return false;
        }
        return call_user_func(array(&$classInstance, $action));
    }
    /**
     *产生唯一ID
     */
    static function runBefore(){
        /*$ssid = getCookie('ssid');
        $ssid = $ssid ? $ssid : '';
        if(!$ssid){
            $ssid = random(13,3);
            makeCookie('ssid', $ssid);
        }
        self::$sessid = $ssid;*/
    }
    /**
     * 设置应用程序路径
     * @param $dir
     */
    static function setAppPath($dir){
        self::$appPath = is_dir($dir) ? $dir : self::$appPath;
    }
    /**
     * 设置模板文件
     * @param $dir
     */
    static function setTempDir($dir){
        self::$templates = is_dir($dir) ? $dir : self::$templates;
    }

    /**
     * 获取路由地址
     *
     */
    static function rules(){
        $rules = F('main');
        if(! empty($rules['rules']) ){
            $spath = $_SERVER['REQUEST_URI'];
            $url_rules = $rules['rules'];
            $spath = trim($spath, '/');
            if($spath){
                foreach($url_rules as $patten => $pth){
                    $patten = str_replace(F('URL_HTML_FIX'), '',$patten);
                    if($patten == $spath){
                        $spath = $pth;
                        break;
                    }elseif(substr($spath,0,3) != substr($patten,0,3) ){
                        continue;
                    }elseif(preg_match_all('/<(\w+):?(.*?)?>/',$patten,$matches)){
                        $tr = array();
                        $tr['/'] = '\\/';
                        $tokens = array_combine($matches[1],$matches[2]);
                        foreach($tokens as $name => $value){
                            if($value === '') $value = '[^\/]+';
                            $tr["<$name>"] = "(?P<$name>$value)";
                            $params[$name] = '';
                        }
                        $p = preg_replace('/<(\w+):?.*?>/','<$1>',$patten);
                        //$pat = '/^'.strtr($p,$tr).'$/';
                        $pat = '/^'.strtr($p,$tr).'/';
                        if(preg_match($pat, $spath, $mat)){
                            foreach($params as $s => $v){
                                $params[$s] = $mat[$s];
                            }
                            \WyPhp\Filter::$gp = array_merge(\WyPhp\Filter::$gp, $params);
                            list($controller, $view) = explode('/', $pth);
                            $view and self::$app['a'] = $view;
                            $controller and self::$app['c'] = $controller;
                            break;
                        }
                    }
                }
            }
        }
    }
    /**
     * 初始化时间和内存
     * @return null
     */
    static function __init(){
        #记录运行时间和内存占用情况
        self::$env['start'] = microtime(true);
        self::$env['mem'] = memory_get_usage();
    }
}

