<?php
namespace App\Controller;
use aceAdmin\Model\GroupModel;
use aceAdmin\Model\ManagerModel;
use WyPhp\DB;

class manager extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            $this->count = DB::count('admin');
            $data = DB::fetch_all('admin','*','',' uid ASC',$this->limit,$this->page);

            $groupModel = new GroupModel();
            $group = $groupModel->getGroup();
            $this->assign('group', $group);
            $this->assign('data', $data);
            $this->tbody_html = $this->fetch('manager/index_data.html');
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionAdd(){
        $manager = new ManagerModel();
        $uid = G('uid','int',0);
        if(IS_POST){
            if(creatToken($uid) != G('formhash')){
                $this->error('无效操作！');
            }

            $data['groupid'] = G('group');
            $data['status'] = G('status') == 'on' ? 1 : 2;
            //$data['status'] = G('status') ? 1 : 2;
            if(G('password')){
                $data['password'] = G('password');
                $data['password1'] = G('password1');
            }
            $msg = '添加成功！';
            if($uid){
                $fal = $manager->update($data, $uid);
                $msg = '编辑成功！';
                if($fal >0){
                    S('sidebarlist'.$uid,null);
                    S('group', null);
                    S('admin'.$uid, null);
                    $this->success($msg);
                }
                $this->error('编辑失败！');
            }else{
                if(!G('user')){
                    $this->error('用户名不能为空！');
                }
                $data['user'] =G('user');
                $uid = $manager->add($data);
                if($uid){
                    $this->outData['reload'] = 1;
                    $this->success($msg);
                }
                $this->error($manager->getError());
            }
            die();
        }
        if($uid){
            $data = $manager->getAdminUser($uid);
            $this->assign('data', $data);
        }
        $groupModel = D('aceAdmin/Group');
        $group = $groupModel->getGroup();
        $this->assign('uid', $uid);
        $this->assign('group', $group);
        $this->render();
    }
    public function actionDel(){
        $id = G('ids');
        $token = G('token');
        if(!$id || $token !=creatToken($id)){
            $this->error('无效操作！');
        }
        if(DB::delete('admin',array('uid'=>$id))){
            $this->outData['reload'] = 1;
            $this->success('操作成功!');
        }
        $this->error('删除失败！');
    }
    public function actionXx(){
        $this->render();
    }
}