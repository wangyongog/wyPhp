<?php
namespace WyPhp;
class Http {
    //multipart/form-data
    //application/json;charset=utf-8
    static $header = [
        'Content-Type' =>'application/x-www-form-urlencoded;charset=utf-8'
    ];

    /**
     * 設置
     * @param array $header
     */
    static function setHeader($header=[]){
        self::$header = $header;
    }

    /**
     * 獲取
     * @return array
     */
    static function getHeader(){
        return self::$header;
    }
    /**
     * 异步发送一个请求
     * @param string $url    请求的链接
     * @param mixed  $params 请求的参数
     * @param string $method 请求的方法
     * @return boolean TRUE
     */
    static function request($url, $params=[], $method = 'POST', $options = []){
        $method = strtoupper($method);
        $protocol = substr($url, 0, 5);
        $httph = curl_init();
        if ('GET' == $method) {
            $query_string = is_array($params) ? http_build_query($params) : $params;
            $url = $query_string ? $url . (stripos($url, "?") !== false ? "&" : "?") . $query_string : $url;
        }else{
            curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式
            curl_setopt($httph, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($httph, CURLOPT_URL, $url);

        if(self::$header){
            curl_setopt($httph,CURLOPT_HTTPHEADER, self::$header);
        }
        curl_setopt($httph, CURLOPT_CONNECTTIMEOUT , isset($options['time']) ? $options['time'] : 10);
        curl_setopt($httph, CURLOPT_TIMEOUT, isset($options['time_out']) ? $options['time_out'] :120);

        if ('https' == $protocol) {
            curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 0);
        }
        if(isset($options['cookie'])){
            curl_setopt($httph, CURLOPT_COOKIE, $options['cookie']);
            curl_setopt($httph, CURLOPT_COOKIEFILE, $options['cookie_file']);
            if($options['cookie_savepath']){
                curl_setopt($httph,CURLOPT_COOKIEJAR,$options['cookie_savepath']);
            }
        }

        curl_setopt($httph,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($httph, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);//"Mozilla/5.0 (compatible; MSIE 6.1; Windows NT 5.0)"

        curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httph, CURLOPT_HEADER, 0);
        $rst = curl_exec($httph);
        if ($errno = curl_errno($httph)) {
            $info = curl_getinfo($httph);
            $err = curl_error($httph);
            curl_close($httph);
            return [
                'code'   => 0,
                'errno' => $errno,
                'msg'   => $err,
                'info'  => $info,
            ];
        }
        curl_close($httph);
        return ['code'=>200, 'data'=>$rst] ;
    }
    /**
     *URL地址解析
     */
    static function parse_base_url($url){
        $url_base = parse_url($url);
    }
}