<?php
class APPbase{
    protected static $map = [];
    protected static $classes =[];
    public static $app = 'app';
    protected static $view = 'Index';
    protected static $controller = 'main';
    public static $env = [];
    public static $user =[];
    public static function run(){
        self::__init();
        define('NL', PHP_OS == 'WINNT' ? "\r\n" : "\n");
        define('TIMESTAMP', $_SERVER['REQUEST_TIME']);
        define('FWPATH', __DIR__);//框架目录
        define('ROOT', substr(__DIR__,0, -10));  //根目录
        //应用程序目录
        if(defined('APP_PATH')){
            self::$app = APP_PATH;
        }
        define('APP_PATH', realpath(self::$app));
        define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        $temp_uri = urldecode($_SERVER['REQUEST_URI']);
        if (strpos($temp_uri, '<') !== false || strpos($temp_uri, '"') !== false){
            exit('Request Bad url');
        }
        define('APP_ROOT', strtolower(strrchr($_SERVER['DOCUMENT_ROOT'], '\\')) );
        //自动加载
        self::register();
        //自定义错误和异常处理
        register_shutdown_function('WyPhp\Error::fatalError');
        //自定义的错误处理
        //set_error_handler('WyPhp\Error::DiyError');
        //自定义异常处理
        //set_exception_handler('WyPhp\Error::WebException');
        define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
        define('IS_GET', REQUEST_METHOD =='GET' ? true : false);
        define('IS_POST',REQUEST_METHOD =='POST' ? true : false);
        define('IS_PUT', REQUEST_METHOD =='PUT' ? true : false);
        define('IS_DELETE',REQUEST_METHOD =='DELETE' ? true : false);
        define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false);
        //加载配置
        self::loadConfig();
        if(false == defined('DEBUG')){
            define('DEBUG', CF('DEBUG')); //是否开启错误调试，true开启，false关闭
        }
        self::rules();
        //启动
        self::_initApp();
    }
    public static function _initApp(){
        $url = parse_url($_SERVER['REQUEST_URI']);
        if(empty($url)){
            header('HTTP/1.1 404 Not Found');
            header('Status:404 Not Found');
            exit;
        }
        $url = trim($url['path'], '/');
        if($url){
            $url = str_replace(CF('URL_HTML_FIX'), '', $url);
            $url = explode('/', $url, 3);
        }
        $controller = !isset(self::$map['c']) ? (isset($url[0]) ? $url[0] : self::$controller) : self::$map['c'];
        $view = !isset(self::$map['a']) ? (isset($url[1]) && !is_numeric($url[1]) ? $url[1] : self::$view) : self::$map['a'];
        define('ACTION', strtolower($view));
        define('CONTROLLER', strtolower($controller));
        $action = 'action'.ucfirst($view);
        if(CF('URL_DENY_SUFFIX') && preg_match('/\.('.trim(CF('URL_DENY_SUFFIX'),'.').')$/i', $controller)){
            \WyPhp\Error::http_status();
        }
        if (!preg_match('/^[A-Za-z](\w)*$/', $controller)) {
            WyPhp\Error::error('file ['.$controller.'] not exists');
        }
        if (!preg_match('/^[A-Za-z_]+$/i', $action)) {
            WyPhp\Error::error('file ['.$controller.'] is ['.$action.'] not exists');
        }
        $filePath = APP_PATH.'/Controller/'. CONTROLLER.'.page.php';
        //命名空间类
        $classname = '\\App\\Controller\\'. CONTROLLER;
        if (class_exists($classname, false)) {
            WyPhp\Error::error('class ['.$classname.'] not exists');
        }
        if(!is_file($filePath)){
            WyPhp\Error::error('file ['.$filePath.'] not exists');
        }
        require_once (realpath($filePath));
        $classInstance = new $classname();
        $method = new \ReflectionMethod($classInstance, $action);
        //self::unregister();
        if($method->isPublic() && method_exists($classInstance, $action)) {
            $method->invoke($classInstance);
        }else{
            WyPhp\Error::error("method[$action] not isPublic in [$classname]");
            return false;
        }
    }
    protected static function loadConfig(){
        $include_file = include ROOT.'/config/api.inc.php';
        if(isset($include_file['core'])){
            foreach ($include_file['core'] as $file){
                if(is_file($file)){
                    include $file;
                }
            }
        }
        if(isset($include_file['configs'])){
            foreach ($include_file['configs'] as $file){
                CF(load_config($file) );
            }
        }
        CF(parse_ini_file($include_file['db'],true));
        //扩展文件
        if($configs = CF('LOAD_CONFIG')){
            if(is_string($configs)) $configs = explode(',',$configs);
            foreach ($configs as $key=>$config){
                $file = is_file($config) ? $config : ROOT.'/config/'.$config.'.inc.php';
                if(is_file($file)) {
                    CF(load_config($file));
                }
            }
        }
    }
    protected static function loadClass($class){
        if(isset(self::$classes[$class])) {
            return include self::$classes[$class];
        }
        $path = FWPATH.'/plugins';
        if(false !== strpos($class, '\\')){
            $name = strstr($class, '\\', true);
            if('App' === $name){
                return self::require_cache(APP_PATH, $class);
            }
            if('Common' === $name){
                return self::require_cache(ROOT.'/'.$name, $class);
            }
            if(!in_array($name,['Common','WyPhp']) && substr($class,-5) =='Model'){
                return self::require_cache(APP_PATH, $class);
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
        if(!file_exists($file)){
            $file = ROOT.DIRECTORY_SEPARATOR. (strstr($class, '\\', true)).DIRECTORY_SEPARATOR.self::$app.str_replace('\\', DIRECTORY_SEPARATOR, strstr($class ,'\\')).'.class.php';
            if(!file_exists($file)){
                WyPhp\Error::debug("file [$file] not exists");
            }
        }
        self::$classes[$class] = $file;
        require_once($file);
    }

    /**
     * 获取路由地址
     *
     */
    protected static function rules(){
        $rules = CF('rules');
        if(! empty($rules) ){
            $spath = $_SERVER['REQUEST_URI'];
            $spath = trim($spath, '/');
            if($spath){
                foreach($rules as $patten => $pth){
                    $patten = str_replace(CF('URL_HTML_FIX'), '',$patten);
                    if($patten == $spath){
                        $spath = $pth;
                        break;
                    }elseif(substr($spath,0,3) != substr($patten,0,3) ){
                        continue;
                    }elseif(preg_match_all('/<(\w+):?(.*?)?>/',$patten,$matches)){
                        $tr = [];
                        $tr['/'] = '\\/';
                        $tokens = array_combine($matches[1],$matches[2]);
                        foreach($tokens as $name => $value){
                            if($value === '') $value = '[^\/]+';
                            $tr["<$name>"] = "(?P<$name>$value)";
                            $params[$name] = '';
                        }
                        $p = preg_replace('/<(\w+):?.*?>/','<$1>',$patten);
                        $pat = '/^'.strtr($p,$tr).'/';
                        if(preg_match($pat, $spath, $mat)){
                            foreach($params as $s => $v){
                                $params[$s] = $mat[$s];
                            }
                            \WyPhp\Filter::$gp = array_merge(\WyPhp\Filter::$gp, $params);
                            list($controller, $view) = explode('/', $pth);
                            $view and self::$map['a'] = $view;
                            $controller and self::$map['c'] = $controller;
                            break;
                        }
                    }
                }
            }
        }
    }
    protected static function register(){
        spl_autoload_register(array('APPbase', 'loadClass'),true, true);
    }

    protected static function unregister(){
        spl_autoload_unregister(array('APPbase', 'loadClass'));
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

