<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 17:01
 */
namespace App\Controller;
use WyPhp\DB;

class user extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            $where = [];
            if(I('username')){
                $where['username'] = I('username');
            }
            $this->count = DB::count('member', $where);
            $data = DB::fetch_all('member','*',$where, 'uid DESC',$this->limit,$this->page);
            $html_row = '';
            $grade = F('TASK_GRADE');
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td><input type="checkbox" class="ids" name="ids[]" value="'.$val['uid'].'" ></td>
                        <td>'.$val['username'].'</td>
                        <td>'.$val['leftmoney'].'</td>
                        <td>'.$grade[$val['grade']].'</td>
                        <td>'.date('Y-m-d H:i:s', $val['addtime']) .'</td>
                        <td>'.($val['endtime'] ? date('Y-m-d H:i:s', $val['endtime']):'') .'</td>
                        <td><a href="javascript:;" onclick="adminJs.showIframe(\'编辑\',\''.U('user/edit',array('uid'=>$val['uid'])).'\',\'700\',\'550\')">编辑</a> </td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
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