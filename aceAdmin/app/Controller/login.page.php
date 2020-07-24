<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Trace;

class login extends baseController {
    public function actionIndex(){
        //$this->caching = false;
        //$this->assign('sss', '11111111');
        //$_SESSION['var2'] = "111";
        //$_SESSION['var3'] = "顶顶顶顶";
        $this->render();
    }
    public function actionLogin(){
        $username = G('username');
        $password = G('password');
        $code = G('code');
        if(check_formhash() === false){
            $this->error('无效操作！');
        }
        $login = D('Manager');
        $flag = $login->login($username, $password);
        if(!$flag){
            $this->error($login->getError());
        }
        $this->success('登录成功','/main');
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