<?php
namespace WyPhp;
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

    public static function get($key, $type = 'string',$default = ''){
        isset(self::$gp[$key]) or self::$gp[$key] = $default;
        return self::getStr(self::$gp[$key], $type ,$default);
    }
    /**
     * 安全过滤数据
     *
     * @param string    $str        需要处理的字符
     * @param string    $type        返回的字符类型，支持，string,int,float,html
     * @param maxid        $default    当出现错误或无数据时默认返回值
     * @param boolean  $checkempty 强制转化为正数
     * @return         mixed        当出现错误或无数据时默认返回值
     */
    public static function getStr($str, $type = 'string', $default = '') {
        switch ($type) {
            case 'string': //字符处理
                $_str = strip_tags($str);
                $_str = htmlspecialchars($_str);
                break;
            case 'int': //获取整形数据
                $_str = (int) $str;
                break;
            case 'float': //获浮点形数据
                $_str = (float) $str;
                break;
            case 'html': //获取HTML，防止XSS攻击
                $_str = self::reMoveXss($str);
                break;
            case 'time':
                $_str = $str ? strtotime($str) : '';
                break;
            default: //默认当做字符处理
                $_str = strip_tags($str);
                break;
        }
        return trim($_str);
    }
    //过滤XSS攻击
    public static function reMoveXss($val) {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <java\0script>
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
        $val = preg_replace('/([\x00-\x08|\x0b-\x0c|\x0e-\x19])/', '', $val);

        // straight replacements, the user should never need these since they're normal characters
        // this prevents like <IMG SRC=@avascript:alert('XSS')>
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            // ;? matches the ;, which is optional
            // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
            // @ @ search for the hex values
            $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
            // @ @ 0{0,7} matches '0' zero to seven times
            $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
        }

        // now the only remaining whitespace attacks are \t, \n, and \r
        $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', '<script', 'object'/* , 'iframe', 'frame', 'frameset', 'ilayer' , 'layer' */, 'bgsound', 'base');
        $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);

        $found = true; // keep replacing as long as the previous round replaced something
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(&#0{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
                $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }
        return $val;
    }
}
