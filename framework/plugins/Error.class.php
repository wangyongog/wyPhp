<?php
namespace WyPhp;
/**
 * 抛出错误类
 * @author Administrator
 * Date: 2016/6/22
 * Time: 17:15
 */
class Error extends \Exception{
    /**
     * 错误信息
     * @var string
     */
    public $error_msg;
    static public $error_code;

    /**
     * 输出调试信息，并结束程序的运行
     * @param $error错误信息
     * @param string $ltype 错误类型，sql,file
     */
    static function debug($error, $ltype='file'){
        if(DEBUG){
            //调试模式下输出错误信息
            if (!is_array($error)) {
                $trace = debug_backtrace();
                $e['message'] = $error;
                $e['file'] = $trace[0]['file'];
                $e['line'] = $trace[0]['line'];
                ob_start();
                debug_print_backtrace();
                $e['trace'] = ob_get_clean();
                ob_end_flush();
            } else {
                $e = $error;
            }
            print_r($e);exit;
        }else{
            Logs::save($error, $ltype);
            //header(self::https());
            //header('Status:404 Not Found');
            redirect(U('Error/index')) ;
        }
    }
    /**
     * 错误信息输出
     * @param $msg
     * @param int $code
     * @throws \Exception
     */
    static function error($msg, $code=0){
        trigger_error($msg, E_USER_ERROR);
    }

    /**
     * @param string $status
     */
    static function http_status($status='404', $msg=''){
        switch ($status){
            case 404:
                header(self::https($status));
                header('Status:404 Not Found');
            break;
            default:
                header(self::https($status));
        }
        edie($msg);
    }
    /**
     * HTTP Protocol defined status codes
     * HTTP协议状态码,调用函数时候只需要将$statu赋予一个下表中的已知值就直接会返回状态了。
     * @param int $statu
     */
    static function https($statu = 404){
        $http = [
            100 => "HTTP/1.1 100 Continue",
            101 => "HTTP/1.1 101 Switching Protocols",
            200 => "HTTP/1.1 200 OK",
            201 => "HTTP/1.1 201 Created",
            202 => "HTTP/1.1 202 Accepted",
            203 => "HTTP/1.1 203 Non-Authoritative Information",
            204 => "HTTP/1.1 204 No Content",
            205 => "HTTP/1.1 205 Reset Content",
            206 => "HTTP/1.1 206 Partial Content",
            300 => "HTTP/1.1 300 Multiple Choices",
            301 => "HTTP/1.1 301 Moved Permanently",
            302 => "HTTP/1.1 302 Found",
            303 => "HTTP/1.1 303 See Other",
            304 => "HTTP/1.1 304 Not Modified",
            305 => "HTTP/1.1 305 Use Proxy",
            307 => "HTTP/1.1 307 Temporary Redirect",
            400 => "HTTP/1.1 400 Bad Request",
            401 => "HTTP/1.1 401 Unauthorized",
            402 => "HTTP/1.1 402 Payment Required",
            403 => "HTTP/1.1 403 Forbidden",
            404 => "HTTP/1.1 404 Not Found",
            405 => "HTTP/1.1 405 Method Not Allowed",
            406 => "HTTP/1.1 406 Not Acceptable",
            407 => "HTTP/1.1 407 Proxy Authentication Required",
            408 => "HTTP/1.1 408 Request Time-out",
            409 => "HTTP/1.1 409 Conflict",
            410 => "HTTP/1.1 410 Gone",
            411 => "HTTP/1.1 411 Length Required",
            412 => "HTTP/1.1 412 Precondition Failed",
            413 => "HTTP/1.1 413 Request Entity Too Large",
            414 => "HTTP/1.1 414 Request-URI Too Large",
            415 => "HTTP/1.1 415 Unsupported Media Type",
            416 => "HTTP/1.1 416 Requested range not satisfiable",
            417 => "HTTP/1.1 417 Expectation Failed",
            500 => "HTTP/1.1 500 Internal Server Error",
            501 => "HTTP/1.1 501 Not Implemented",
            502 => "HTTP/1.1 502 Bad Gateway",
            503 => "HTTP/1.1 503 Service Unavailable",
            504 => "HTTP/1.1 504 Gateway Time-out"
        ];
        return $http[$statu];
    }
    /**
     * 错误类型
     * @param $errCode
     */
    public static function errorType(){
        return [
            E_ERROR          => 'ERROR',//1
            E_WARNING        => 'WARNING',//2
            E_PARSE          => 'PARSING ERROR',//4
            E_NOTICE         => 'NOTICE',//8
            E_CORE_ERROR     => 'CORE ERROR',//16
            E_CORE_WARNING   => 'CORE WARNING',//32
            E_COMPILE_ERROR  => 'COMPILE ERROR',//64
            E_COMPILE_WARNING => 'COMPILE WARNING',
            E_USER_ERROR     => 'USER ERROR',
            E_USER_WARNING   => 'USER WARNING',
            E_USER_NOTICE    => 'USER NOTICE',
            E_STRICT         => 'STRICT NOTICE',
            E_RECOVERABLE_ERROR  => 'RECOVERABLE ERROR'
        ];
    }
    /**
     *致命错误捕获
     */
    public static function fatalError(){
        $e = error_get_last();
        if ($e && in_array($e['type'], [1, 4, 16, 64, 256, 4096])) {
            ob_end_clean();
            self::debug($e);
            /*switch($e['type']){
                case E_ERROR:
                    ob_end_clean();
                    self::debug($e);
                    break;
                case E_PARSE:
                case E_USER_ERROR:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_WARNING:
            }*/
        }
    }

    /**
     * use  trigger_error('错误信息', E_USER_ERROR);
     * 自定义错误处理
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
    public static function DiyError($errCode, $errMsg='', $errFile='', $errLine=''){
        switch ($errCode) {
            //case E_PARSE:
            //case E_WARNING:
            //case E_USER_NOTICE:
            //case E_NOTICE:
            //case E_CORE_ERROR:
            //case E_COMPILE_ERROR:
            //case E_ERROR:
            case E_USER_ERROR :
                $errorStr = $errMsg .$errFile.' 第'. $errLine.' 行';
                self::debug($errorStr);
                break;
            default:
                $errorStr = $errMsg .'  '. $errFile.' 第'. $errLine.' 行';
                //self::debug($errorStr);
                break;
        }
    }
    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    public static function WebException($e){
        $error = [];
        $error['message'] = $e->getMessage();
        $trace = $e->getTrace();
        if('error'==$trace[0]['function']) {
            $error['file'] = $trace[0]['file'];
            $error['line'] = $trace[0]['line'];
        }else{
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
        }
        $error['trace'] = $e->getTraceAsString();
        self::debug($error);
    }

}