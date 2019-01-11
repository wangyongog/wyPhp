<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 17:01
 */
namespace App\Controller;
use WyPhp\DB;

class rate extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            $where = [];
            $this->count = DB::count('rate', $where);
            $data = DB::fetch_all('rate','*',$where, 'id DESC',$this->limit,$this->page);
            $html_row = '';
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td><input type="checkbox" class="ids" name="ids[]" value="'.$val['id'].'" ></td>
                        <td>'.$val['timesd'].'</td>
                        <td>'.F('STAUTE')[$val['staute']].'</td>
                        
                        <td><a href="javascript:;" onclick="adminJs.showIframe(\'编辑\',\''.U('rate/edit',array('id'=>$val['id'])).'\',\'700\',\'550\')">编辑</a> | <a href="javascript:;" _url="'.U('rate/del',array('id'=>$val['id'],'token'=>creatToken($val['id']))).'" class="del">删除</a></td>
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
            $data['staute'] = I('staute');
            $data['timesd'] = I('timesd');
            if(empty(I('timesd'))){
                $this->error('请选择时间段！');
            }
            $data['addtime'] = TIMESTAMP;
            $msg = '添加成功！';
            $uid = DB::insert('rate', $data);
            if($uid>0){
                $this->success($msg);
            }
            $this->error('添加失败！');
        }
        $this->assign('staute', F('STAUTE') );
        $this->render();
    }
    public function actionDel(){
        $id = I('id','int',0);
        $token = I('token');
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('rate',array('id'=>$id))){
            $data['info'] = '操作成功！';
            $data['status'] = 1;
            $data['reload'] = 1;
            $this->printJson($data);
        }
        $this->error('删除失败！');
    }
    public function actionEdit(){
        $id = I('id','int');
        if(IS_AJAX && $id){
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }

            $data['staute'] = I('staute');
            $data['timesd'] = I('timesd');
            if(empty(I('timesd'))){
                $this->error('请选择时间段！');
            }
            if(DB::update('rate', $data, array('id' =>$id))){
                $this->success('编辑成功！');
            }
            $this->error('编辑失败！');
        }
        $udata = DB::fetch_first('rate','*',array('id'=>$id));
        $this->assign('data', $udata);
        $this->assign('id', $id);
        $this->assign('staute', F('STAUTE') );
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