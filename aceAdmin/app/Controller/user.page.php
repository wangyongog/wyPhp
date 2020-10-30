<?php
namespace App\Controller;
use WyPhp\DB;

class user extends baseController{

    public function actionPass(){
        $manager = D('aceAdmin/Manager');
        $uid = G('uid','int',0);
        if(IS_POST){
            if(creatToken($this->admin['uid']) != G('formhash')){
                $this->error('无效操作！');
            }
            $old_pass = G('old_pass');
            $data['password'] = G('password');
            $data['password1'] = G('password1');
            if(!$old_pass){
                $this->error('请输入旧密码');
            }
            if(!$data['password']){
                $this->error('请输入新密码');
            }
            if($data['password'] != $data['password1']){
                $this->error('2次密码不一致');
            }
            if(!$manager->pwdVerify($old_pass, $this->admin['password'])){
                $this->error('旧密码不正确');
            }
            $fal = $manager->update($data, $this->admin['uid']);
            $msg = '编辑成功！';
            if($fal >0){
                $this->success($msg);
            }
            $this->error($manager->getError());

            die();
        }
        $this->render();
    }

}