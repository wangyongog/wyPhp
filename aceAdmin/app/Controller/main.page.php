<?php
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