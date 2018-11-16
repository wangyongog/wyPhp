<?php
namespace WyPhp;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 17:52
 */
class Filter{
    public static $gp = []; //GET、POST传递的参数
    //重写get post
    public static function loadGetPost(){
        $getfilter = "(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
        $postfilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
        $cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
        if (!empty($_GET) ){
            foreach($_GET as $k=>$v){
                $val = is_array($v) ? serialize($v) : $v;
                if(preg_match('/'.$getfilter.'/is',$val) == 1){
                    Error::debug($val , 'GET');
                    //Error::write($val , 'GET');
                    continue;
                }
                self::$gp[$k] = $v;
            }
        }

        if(!empty($_POST) ){
            foreach($_POST as $k=>$v){
                $val = is_array($v) ? serialize($v) : $v;
                if(preg_match('/'.$postfilter.'/is',$val) == 1){
                    Error::debug($val , 'POST');
                    //Error::write($val , 'POST');
                    continue;
                }
                self::$gp[$k] = $v;
            }
        }
        if(!empty($_COOKIE)){
            foreach($_COOKIE as $s => $v){
                $val = is_array($v) ? serialize($v) : $v;
                if(preg_match('/'.$cookiefilter.'/is',$val) == 1){
                    Error::debug($val , 'COOKIE');
                    //Error::write();
                    unset($_COOKIE[$s]);
                    continue;
                }
                $_COOKIE[$s] = self::daddslashes($v);
            }
        }

        if ( !empty($_FILES)) {
            $_FILES = self::daddslashes($_FILES);
        }
        unset($_GET,$_POST,$_REQUEST);
    }
    private static function daddslashes($string){
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = self::daddslashes($val);
            }
        } else {
            $string = MAGIC_QUOTES_GPC ? strip_tags(stripslashes($string)) : strip_tags($string);
        }
        return $string;
    }
    static function safe(&$content){
        $content = stripslashes($content);//删除由addslashes反斜杠
        $content = html_entity_decode($content, ENT_QUOTES); //HTML 解码双引号和单引号实体转换为字符
        return $content;
    }
    public static function get($key, $type = 'string',$default = ''){
        isset(self::$gp[$key]) or self::$gp[$key] = $default;
        return Sutil::getStr(self::$gp[$key], $type ,$default);
    }
}