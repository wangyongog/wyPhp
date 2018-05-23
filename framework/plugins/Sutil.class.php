<?php
namespace WyPhp;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 18:00
 */
class Sutil{
    /**
     * 数组转字符串
     * @param $arr
     * @param string $sp
     * @return bool|string
     */
    public static function arrTostr($arr, $sp = ',') {
        if (!$arr)
            return false;
        return implode($sp, $arr);
    }
    /**
     * 根据键值 数组排序
     * @param array $array 数组
     * @param $key  键值
     * @param string $asc
     * @return array
     */
    static function array_sort(array $array, $key, $asc = 'asc'){
        $result = array();
        foreach ($array as $k => &$v) {
            $values[$k] = isset($v[$key]) ? $v[$key] : '';
        }
        unset($v);
        $asc == 'asc' ? asort($values) : arsort($values);   // 重新排列原有数组
        foreach ($values as $k => $v) {
            $result[$k] = $array[$k];
        }
        return $result;
    }
    /**
     * 删除由 addslashes() 函数添加的反斜杠
     * @param $val
     * @return string
     */
    static function stripslashes($val){
        return stripslashes($val);
    }
    /**
     * 对输入字符串中的某些预定义字符前添加反斜杠
     * @param $val
     * @return string
     */
    static function addslashes($val){
        return addslashes($val);
    }

    /**
     * 加密与解密字串
     * @param array $value 要加解密字符串
     * @param $operation  ENCODE 加密，
     * @param $skey 加密串
     * @return string
     */
    public static function mcrypt($value, $operation = 'ENCODE', $skey = '') {
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
     * 截取utf8字符串,完美支持中文
     * @param string $str 截取的字符串
     * @param int $len 截取长度
     * @param int $from 从那个位置开始截取
     * @param string $adddot 截取后用什么填充 默认...
     * @return mixed|string
     */

    public static function substring($str, $len, $adddot = '...', $from = 0) {
        if ($adddot && mb_strlen($str, 'utf-8') > intval($len)) {
            return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $str) . "..";
        } else {
            return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s', '$1', $str);
        }
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
                $_str = htmlspecialchars($_str, ENT_QUOTES);
                /*$_str = str_replace('\'', '&#39;', $_str);
                $_str = str_replace('\"', '&quot;', $_str);
                $_str = str_replace('\\', '', $_str);
                $_str = str_replace('\/', '', $_str); */
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
    static function reMoveXss($val) {
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

    /**
     * XML编码
     * @param mixed $data 数据
     * @param string $root 根节点名
     * @param string $item 数字索引的子节点名
     * @param string $attr 根节点属性
     * @param string $id   数字索引子节点key转换的属性名
     * @param string $encoding 数据编码
     * @return string
     */
    function xml_encode($data, $root='wyphp', $item='item', $attr='', $id='id', $encoding='utf-8') {
        if(is_array($attr)){
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr   = trim($attr);
        $attr   = empty($attr) ? '' : " {$attr}";
        $xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
        $xml   .= "<{$root}{$attr}>";
        $xml   .= data_to_xml($data, $item, $id);
        $xml   .= "</{$root}>";
        return $xml;
    }
    /**
     * 数据XML编码
     * @param mixed  $data 数据
     * @param string $item 数字索引时的节点名称
     * @param string $id   数字索引key转换为的属性名
     * @return string
     */
    function data_to_xml($data, $item='item', $id='id') {
        $xml = $attr = '';
        foreach ($data as $key => $val) {
            if(is_numeric($key)){
                $id && $attr = " {$id}=\"{$key}\"";
                $key  = $item;
            }
            $xml    .=  "<{$key}{$attr}>";
            $xml    .=  (is_array($val) || is_object($val)) ? data_to_xml($val, $item, $id) : $val;
            $xml    .=  "</{$key}>";
        }
        return $xml;
    }
}