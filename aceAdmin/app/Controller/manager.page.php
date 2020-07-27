<?php
namespace App;
use Admin\GroupModel;
use Admin\ManagerModel;
use WyPhp\DB;

class manager extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            $manager = new ManagerModel();
            $this->count = DB::count($manager->table);
            $data = DB::fetch_all($manager->table,'*','',' uid ASC',$this->limit,$this->page);
            $html_row = '';
            $groupModel = new GroupModel();
            $group = $groupModel->getGroup();
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td class="center"><label class="pos-rel"><input id="ids" name="ids[]" value="'.$val['uid'].'" type="checkbox" class="ace ids"><span class="lbl"></span></label></td>
                        <td>'.$val['user'].'</td>
                        <td>'.$group[$val['groupid']]['title'].'</td>
                        <td>'. ($val['lasttime'] ? date('Y-m-d H:i:s', $val['lasttime']):'') .'</td>
                        <td>'.($val['status'] == 1 ? '正常':'锁定').'</td>
                        <td>'.($val['addtime'] ? date('Y-m-d H:i:s', $val['addtime']):'') .'</td>
                        <td><a href="javascript:;" _url="'.U('manager/add',array('uid'=>$val['uid'],'token'=>creatToken($val['uid']))).'" _wh="550,450" class="edit">编辑</a> | <a href="javascript:;" _url="'.U('manager/del',array('uid'=>$val['uid'],'token'=>creatToken($val['uid']))).'" class="del">删除</a></td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionAdd(){
        $manager = new ManagerModel();
        $uid = G('uid','int',0);
        if(IS_AJAX){
            if(creatToken($uid) != G('formhash')){
                $this->error('无效操作！');
            }

            $data['groupid'] = G('group');
            $data['status'] = G('status') ? 1 : 2;
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
                if($uid !=false){
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
        $groupModel = NEW GroupModel();
        $group = $groupModel->getGroup();
        $this->assign('uid', $uid);
        $this->assign('group', $group);
        $this->render();
    }
    public function actionDel(){
        $id = G('uid','int',0);
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