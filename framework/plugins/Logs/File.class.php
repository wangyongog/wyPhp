<?php
namespace WyPhp\Logs;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 14:09
 */
class File{
    /**
     * @param string $message  错误信息
     * @param string $type 错误类型
     */
    public function write($message='', $type=''){
        //文件日志记录
        $path = ROOT . F('ERROR_PATH').'/'.date('Ym').'/'.$type;
        cmkdir($path, 0777);
        if (is_dir($path)) {
            $message = date('Y-m-d H:i:s', TIMESTAMP)  . ' | ' . getIP() . ' | ' . $message . ' | ' . $_SERVER['REQUEST_URI'] . NL . NL;
            file_put_contents($path . '/' . date('Y-m-d', TIMESTAMP) . '_' . ($type ?$type :'file')  . '.log', $message, FILE_APPEND);
        }
    }
}