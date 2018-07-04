<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 16:14
 */
namespace App\Controller;
//use Admin\Model\LoginModel;

class login extends baseController {
    public function actionIndex(){
        //$this->caching = false;
        //$this->assign('sss', '11111111');
        $_SESSION['var2'] = "111";
        $_SESSION['var3'] = "顶顶顶顶";
        //$this->render();
    }
    public function actionLogin(){
        $username = I('username');
        $password = I('password');
        $code = I('code');
        if(check_formhash(I('formhash')) === false){
            $this->error('无效操作11111！');
        }
        $login = D('Admin/Manager');
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