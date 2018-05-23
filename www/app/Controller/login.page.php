<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26
 * Time: 16:33
 */

namespace App\Controller;
use WyPhp\Filter;

class login extends baseController{
    public function actionIndex(){
        //$this->craetHtml();
        //exit;
        $this->render();
    }
    public function actionLogin(){
        $username = I('username');
        $password = I('password');
        if(check_formhash() === false){
            $this->error('无效操作！');
        }
        if(!$username || !$password){
            $this->error('请输入用户名或密码！');
        }
        $login = D('Member');
        $uid = $login->login($username, $password);
        if($uid>0){
            $this->success('登录成功','/main');
        }
        switch ($uid) {
            case - 1 :
                $error = '用户不存在！';
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
    public function actionRegister(){
        if(IS_AJAX){
            $username = I('username');
            $password = I('password');
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            if(!$username || !$password){
                $this->error('请输入用户名或密码！');
            }
            $member = D('Member');
            $data['username'] = $username;
            $data['password'] = $password;
            $data['phone'] = I('phone');
            if(isMobile($data['phone']) == false){
                $this->error('手机号码有误！');
            }
            $uid = $member->register($data);
            if($uid>0){
                $this->success('登录成功','/main');
            }
            $error = $uid<0 ? $member->showRegError($uid) : '未知错误！';
            $this->error($error);
        }
        $this->render();
    }
    public function actionLoginout(){
        print_r(json_encode(Filter::$gp) );exit;
        echo 'sss';exit;
        session('uidMb',null);
        session_destroy();
        $url = U('login/index');
        redirect($url);
    }
}