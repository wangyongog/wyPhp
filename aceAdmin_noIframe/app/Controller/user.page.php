<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class user extends baseController{
    public function actionIndex(){
        $where = [];
        if(G('username')){
            $where['username'] = G('username');
        }

        $this->count = DB::count('member', $where);
        $data = DB::fetch_all('member','*',$where, 'uid DESC',$this->limit,$this->page);
        $this->pageBar();
        $grade = CF('TASK_GRADE');

        $this->assign('grade', $grade);
        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        if(IS_AJAX){
            if(check_formhash(G('formhash')) === false){
                $this->error('无效操作！');
            }
            if(!G('username')){
                $this->error('请输入用户名！');
            }
            if(!G('password') || !G('password1')){
                $this->error('请输入密码！');
            }
            if(G('password') != G('password1')){
                $this->error('2次密码不一致！');
            }
            $member = D('member');
            $data['username'] = G('username');
            $data['password'] = $member->creatPassWorld(G('password'));
            $data['hash'] = random();
            $data['addtime'] = TIMESTAMP;
            $data['map'] = 1;
            $data['status'] = G('status') ? 1 : 2;

            $msg = '添加成功！';
            $uid = DB::insert('member', $data);
            if($uid>0){
                $this->success($msg);
            }
            $this->error('添加失败！');
        }
        $this->assign('gradelist', CF('TASK_GRADE') );
        $this->render();
    }
    public function actionEdit(){
        $uid = G('uid','int');
        if(!$uid){
            $this->error('无效参数！');
        }
        $member = D('member');
        if(IS_AJAX && $uid){
            if(check_formhash(G('formhash')) === false){
                $this->error('无效操作！');
            }
            if(G('password') || G('password1')){
                if(!G('password') || !G('password1')){
                    $this->error('请输入密码！');
                }
                if(G('password') != G('password1')){
                    $this->error('2次密码不一致！');
                }
                $data['password'] = $member->creatPassWorld(G('password'));
            }
            $data['grade'] = G('grade', 'int');
            $data['hash'] = random();
            $data['status'] = G('status') ? 1 : 2;
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
        $id = G('uid','int',0);
        $token = G('token');
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
        $uid = G('uid', 'int');
        $username = G('username');
        $content = G('content');
        $money = G('money', 'float');
        if(IS_AJAX){
            if(!$money){
                $this->error('请输入金额！');
            }
            if(!$content){
                $this->error('请填写备注！');
            }
            if(G('token') != creatToken($uid)){
                $this->error('无效操作！');
            }
            if(check_formhash(G('formhash')) === false){
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