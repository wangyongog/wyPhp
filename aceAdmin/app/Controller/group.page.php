<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class group extends baseController{
    public function actionIndex(){

        $groupModel = D('aceAdmin/Group');
        $data = $groupModel->getGroup();
        $this->assign('data', $data);
        $this->render();
    }
    public function actionEdit(){
        $id = I('groupid','int');
        if (!$id) {
            $this->error('参数错误！');
        }
        $group = DB::fetch_first('auth_group','*',['groupid'=>$id]);
        if (!$group) {
            $this->error('参数错误！');
        }
        $this->render();
    }
    public function actionAdd(){
        $groupid = I('groupid');
        if(IS_AJAX){
            $data['status'] = I('status') == 'on' ? 1 : 0;
            $data['title'] = I('title');
            if(empty($data['title'])){
                $this->error('用户组名不能为空！');
            }
            $rules = Filter::$gp['rules'] ? Filter::$gp['rules'] : '';
            if (!empty($rules)) {
                foreach ($rules as $k => $v) {
                    $rules[$k] = intval($v);
                }
                $rules = implode(',', $rules);
            }
            $data['rules'] = $rules;
            $this->outData['location'] = 1;
            S('group',null);
            if ($groupid) {
                $group = DB::update('auth_group', $data, ['groupid'=>$groupid]);
                if ($group) {
                    $this->success('恭喜，用户组修改成功！',U('/group'));
                } else {
                    $this->error('未修改内容',U('/group'));
                }
            } else {
                DB::insert('auth_group', $data);
                $this->success('恭喜，新增用户组成功！',U('/group'));
            }
            die();
        }
        if($groupid){
            $group = DB::fetch_first('auth_group','*', ['groupid'=>$groupid]);
            $this->assign('data', $group);
        }
        $this->render();
    }
    public function actionDel(){
        $id = I('groupid','int',0);
        $token = I('token');
        if(!$id || $token !=creatToken($id)){
            $this->error('无效操作！');
        }
        if(DB::delete('auth_group',array('groupid'=>$id))){
            $this->outData['reload'] = 1;
            S('group',null);
            $this->success('操作成功!');
        }
        $this->error('删除失败！');
    }
}