<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 17:01
 */
namespace App\Controller;
use WyPhp\DB;

class user extends baseController {
    public function actionIndex(){
        $this->render();
    }
    public function actionPwd(){
        if( I('token') != creatToken($this->uid)){
            $this->error('无效操作！');
        }
        $oldpasword = I('oldpasword');
        $pasword = I('pasword');
        $pasword1 = I('pasword1');
        if(!$pasword || !$pasword || !$pasword1){
            $this->error('请输入原密码或新密码！');
        }
        if(!$pasword != !$pasword1){
            $this->error('2次密码不一致！');
        }
        $member = D('Member');
        $pwd = $member->member(array('uid'=>$this->uid), 'password');
        if($member->pwdVerify($oldpasword, $pwd['password']) != true){
            $this->error('原密码不正确！');
        }
        $pasword = $member->creatPassWorld($pasword);
        if(DB::update($member->table,array('password' =>$pasword), array('uid'=>$this->uid))){
            $this->success('修改成功！',U('/main'));
        }
        $this->error('原密码不正确！');
    }
}