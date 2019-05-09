<?php
namespace WyPhp;
class CssJs {
    protected $path = '';
    protected static $css_js = [];
    protected $cssJsList = '';

    /**
     * 动态加载css js
     * @param $path_arr
     * @return mixed|string|void
     */
    public function loadCss_js($path_arr){
        if(!is_array($path_arr)) return;
        foreach ($path_arr as $v){
            $this->cssJsList .= self::getCss_js($v).NL;
        }
        return $this->cssJsList;
    }
    protected function getCss_js($path){
        if(isset(self::$css_js[md5($path)])) return self::$css_js[md5($path)];

        $path_arr = explode('.', $path);
        $ext = end($path_arr);
        switch ($ext){
            case 'js':
                $str = '<script type="text/javascript" src="'.CF('DOMAIN')['assets'].'/'.$path.'?v='.$this->CssJsVersion($path).'"></script>';
            break;
            case 'css':
                $str = '<link href="'.CF('DOMAIN')['assets'].'/'.$path.'?v='.$this->CssJsVersion($path).'" rel="stylesheet" type="text/css" />';
            break;
        }
        self::$css_js[md5($path)] = $str;
        return $str;
    }


    /**
     * 返回文件最后修改时间
     * @param $path
     * @return false|string
     */
    protected function CssJsVersion($path){
        return date('YmdHi', filemtime(ROOT.'/assets/'.$path)) ;
    }

}