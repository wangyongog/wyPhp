<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26
 * Time: 16:33
 */

namespace App\Controller;
class logout extends baseController{
    public function actionIndex(){
        session('uidMb',null);
        session_destroy();
        $url = U('login/index');
        redirect($url);
    }
}