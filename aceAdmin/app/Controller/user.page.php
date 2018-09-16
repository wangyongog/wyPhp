<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 17:01
 */
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class user extends baseController{
    public function actionIndex(){
        $where = [];
        if(I('username')){
            $where['username'] = I('username');
        }
$this->limit =1;
        $this->count = DB::count('member', $where);
        $data = DB::fetch_all('member','*',$where, 'uid DESC',$this->limit,$this->page);
        $this->pageBar();
        $grade = F('TASK_GRADE');

        $this->assign('grade', $grade);
        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        if(IS_AJAX){
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            if(!I('username')){
                $this->error('请输入用户名！');
            }
            if(!I('password') || !I('password1')){
                $this->error('请输入密码！');
            }
            if(I('password') != I('password1')){
                $this->error('2次密码不一致！');
            }
            $member = D('member');
            $data['username'] = I('username');
            $data['password'] = $member->creatPassWorld(I('password'));
            $data['hash'] = random();
            $data['addtime'] = TIMESTAMP;
            $data['map'] = 1;
            $data['status'] = I('status') ? 1 : 2;

            $msg = '添加成功！';
            $uid = DB::insert('member', $data);
            if($uid>0){
                $this->success($msg);
            }
            $this->error('添加失败！');
        }
        $this->assign('gradelist', F('TASK_GRADE') );
        $this->render();
    }
    public function actionEdit(){
        $uid = I('uid','int');
        if(!$uid){
            $this->error('无效参数！');
        }
        $member = D('member');
        if(IS_AJAX && $uid){
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            if(I('password') || I('password1')){
                if(!I('password') || !I('password1')){
                    $this->error('请输入密码！');
                }
                if(I('password') != I('password1')){
                    $this->error('2次密码不一致！');
                }
                $data['password'] = $member->creatPassWorld(I('password'));
            }
            $data['grade'] = I('grade', 'int');
            $data['hash'] = random();
            $data['status'] = I('status') ? 1 : 2;
            if(DB::update('member', $data, array('uid' =>$uid))){
                $this->success('编辑成功！');
            }
            $this->error('编辑失败！');
        }

        $udata = $member->member(array('uid'=>$uid) ,'username,uid,grade,status,price_config');
        $this->assign('data', $udata);
        $this->assign('uid', $uid);
        $this->assign('gradelist', F('TASK_GRADE') );
        $this->render();
    }
    public function actionDel(){
        $id = I('uid','int',0);
        $token = I('token');
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('member',array('uid'=>$id))){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
    public function actionLeftmoney(){
        $uid = I('uid', 'int');
        $username = I('username');
        $content = I('content');
        $money = I('money', 'float');
        if(IS_AJAX){
            if(!$money){
                $this->error('请输入金额！');
            }
            if(!$content){
                $this->error('请填写备注！');
            }
            if(I('token') != creatToken($uid)){
                $this->error('无效操作！');
            }
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            $member = D('member');
            $user = $member->member(array('uid' =>$uid), 'uid');
            if (! $user) {
                $this->error( '此用户不存在' );
            }
            $data = $user_data = array();
            $balance = D('balance');
            $remark = '管理员【'.$this->admin['user'].'】调整了余额'. $money . '￥ : ' . $content;
            $fal = $balance->leftmoney($uid, $money, $remark, 8);
            if($fal){
                $this->success('操作成功！');
            }
            $this->error('操作失败！');
            die();
        }
        $this->assign('uid', $uid);
        $this->assign('uname', $username);
        $this->render();
    }
}