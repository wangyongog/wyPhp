<?php
namespace App\Controller;
use aceAdmin\Model\ManagerModel;
use Common\Model\PrizesModel;
use Common\Model\v3_ArchivesModel;
use WyPhp\DB;
use WyPhp\Trace;

class login extends baseController {
    public function _initialize(){

    }

    public function actionIndex(){
        //$login = new v3_ArchivesModel();
        $this->render();
    }
    public function actionLogin(){
        $username = G('username');
        $password = G('password');
        $code = G('code');
        if(check_formhash() == false){
            $this->error('无效操作！');
        }
        $login = new ManagerModel();
        $uid = $login->login($username, $password);
        if($uid>0){
            $this->success('登录成功','/main');
        }
        switch ($uid) {
            case - 1 :
                $error = '用户不存在或被禁用！';
                break; // 系统级别禁用
            case - 2 :
                $error = '密码错误！';
                break;
            default :
                $error = '未知错误！';
                break;
        }
        $this->error($error);
    }
    public function actionVerify(){
        $config = array(
            'imageW'    =>    160,
            'imageH'    =>    40,
            'fontSize'    =>    22,    // 验证码字体大小
            'length'    =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useCurve' =>false
        );
        $verify = new \WyPhp\Verify($config);
        $verify->entry('loginmy');
    }
}