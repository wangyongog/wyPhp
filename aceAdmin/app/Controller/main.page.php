<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 14:38
 */
namespace App\Controller;
use WyPhp\Cache;
use WyPhp\DB;
use WyPhp\Trace;

class main extends baseController {
    public function actionIndex(){
        //echo '1111';exit;
        $this->render();

    }
    public function actionCheshi(){
        $this->render();
    }
    public function actionDefault(){
        $this->render();
    }
    public function actionGetNum(){
        $data = array();
        $taskModel = D('Task');
        $arr = DB::fetch_all('task','`from`,`type`,tid', array ('status'=>0));
        if(!empty($arr)){
            foreach ($arr as $v){
                if($v['type'] == 'gaosu'){
                    $v['type'] = 'task';
                }
                $data[$v['type']] += 1;
            }
        }
        $tasklog = DB::count('mlog', array ('isstatus' => 1) );
        if($tasklog>0){
            $data['tasklog'] = $tasklog;
        }
        $recharge = DB::count('recharge', array('status'=>1));
        if($recharge){
            $data['recharge'] = $recharge;
        }
        if(!empty($data)){
            $this->success('ok' ,'',$data);
            die();
        }
        $this->error('提交失败');
    }
    public function actionClear(){
        $cache = Cache::connect();
        $cache->clear();
        rmdirr(ROOT.'/data');
        $this->success('系统缓存清除成功！');
    }
    public function actionLogout(){
        session('uidHahs', null);
        session_destroy();
        $url = U('login/index');
        redirect($url);
    }
}