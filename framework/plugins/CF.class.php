<?php
namespace WyPhp;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/19
 * Time: 9:54
 */
class CF {
    private static $ext = '.inc.php';
    public static $_config=[];

    /**
     * 获取配置参数
     * @param null $name 参数名或文件名
     * @return array|mixed|null
     */
    public static function get($name = null){
        if(!$name) return [];
        if(isset(self::$_config[$name])){
            return self::$_config[$name];
        }
        if(strpos($name ,'/') === false){
            if(is_file(ROOT.'/config/'.$name.self::$ext)){
                $file = ROOT.'/config/'.$name.self::$ext;
            }
            if(is_file($_SERVER['DOCUMENT_ROOT'].'/config/'.$name.self::$ext)){
                $file = $_SERVER['DOCUMENT_ROOT'].'/config/'.$name.self::$ext;
            }
            if(!empty($file) && $name!='db'){
                $data = self::load_config($file);
                self::set($data);
            }
            if($name =='db'){
                $data = parse_ini_file($file,true);
                self::set($data);
            }
            return isset(self::$_config[$name]) ? self::$_config[$name] : self::$_config;
        }
        $name = explode('/', $name);
        //存在直接返回
        if(isset(self::$_config[$name[0]][$name[1]])){
            return self::$_config[$name[0]][$name[1]];
        }
        if(is_file(ROOT.'/config/'.$name[0].self::$ext)){
            $file = ROOT.'/config/'.$name[0].self::$ext;
        }elseif(is_file($_SERVER['DOCUMENT_ROOT'].'/config/'.$name[0].self::$ext)){
            $file = $_SERVER['DOCUMENT_ROOT'].'/config/'.$name[0].self::$ext;
        }
        if(!empty($file)){
            $data = self::load_config($file);
            self::set($data);
        }
        return isset(self::$_config[$name[0]][$name[1]]) ? self::$_config[$name[0]][$name[1]] : null;
    }

    /**
     * @param $name
     * @param null $value
     * @return bool
     */
    public static function set($name, $value=null){
        if(is_file($name)){
            $name = self::load_config($name);
        }
        if(is_array($name)){
            self::$_config = array_merge(self::$_config, $name);
        }
        if(!is_null($value)){
            self::$_config[$name] = $value;
        }
        return self::$_config;
    }
    /**
     * 加载配置文件 支持格式转换 仅支持一级配置
     * @param string $file 配置文件名
     * @param string $parse 配置解析方法 有些格式需要用户自己解析
     * @return array
     */
    static function load_config($file,$parse=''){
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
    }
}