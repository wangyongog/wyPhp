<?php
namespace WyPhp\Logs;
class File{
    /**
     * @param string $message  错误信息
     * @param string $type 错误类型
     */
    public function write($message='', $type=''){
        $type = $type ? $type : 'file';
        //文件日志记录
        $path = ROOT . CF('ERROR_PATH').'/'.date('Ymd').'/'.$type;
        cmkdir($path, 0777);
        if (is_dir($path)) {
            $message = date('Y-m-d H:i:s', TIMESTAMP)  . ' | ' . getIP() . ' | ' . $message . ' | ' .( is_ssl() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/'.CONTROLLER.'/'.ACTION . NL . NL;
            file_put_contents($path . '/' . date('Y-m-d', TIMESTAMP) . '_' . $type  . '.log', $message, FILE_APPEND);
        }
    }
}