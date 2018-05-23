<?php
namespace WyPhp\Logs;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 14:09
 */
class Db{
    public function write($message='', $type=''){
        $data['ltype'] = $type;
        $data['url'] = $_SERVER['REQUEST_URI'];
        $data['addtime'] = TIMESTAMP;
        $data['msg'] = $message;
        $data['error'] = '';
        \WyPhp\DB::insert('error', $data, false,['prefix' =>'log_']);
    }
}
