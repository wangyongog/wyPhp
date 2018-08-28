<?php
namespace App\Controller;
use WyPhp\DB;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/6
 * Time: 16:40
 */
class manager extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            $manager = D('Admin/Manager');
            $this->count = DB::count($manager->table);
            $data = DB::fetch_all($manager->table,'*','',' uid ASC');
            $html_row = '';
            $groupModel = D('Admin/Group');
            $group = $groupModel->getGroup();
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td><input type="checkbox" class="ids" name="ids[]" value="'.$val['uid'].'" ></td>
                        <td>'.$val['user'].'</td>
                        <td>'.$group[$val['groupid']]['title'].'</td>
                        <td>'. ($val['lasttime'] ? date('Y-m-d H:i:s', $val['lasttime']):'') .'</td>
                        <td>'.($val['status'] == 1 ? '正常':'锁定').'</td>
                        <td>'.($val['addtime'] ? date('Y-m-d H:i:s', $val['addtime']):'') .'</td>
                        <td><a href="javascript:;" _url="'.U('manager/add',array('uid'=>$val['uid'],'token'=>creatToken($val['uid']))).'" _wh="550,450" class="edit">编辑</a></td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionAdd(){
        $manager = D('Admin/Manager');
        $uid = I('uid','int',0);
        if(IS_AJAX){
            if(creatToken($uid) != I('formhash')){
                $this->error('无效操作！');
            }
            $data['groupid'] = I('group');
            $data['status'] = I('status') ? 1 : 2;
            if(I('password')){
                $data['password'] = I('password');
                $data['password1'] = I('password1');
            }
            $msg = '添加成功！';
            if($uid){
                $uid = $manager->update($data, $uid);
                $msg = '编辑成功！';
                if($uid >0){
                    $this->success($msg);
                }
                $this->error('编辑失败！');
            }else{
                $data['user'] = I('user');
                $uid = $manager->add($data);
                if($uid !=false){
                    $this->success($msg);
                }
                $this->error($manager->getError());
            }
        }
        if($uid){
            $data = $manager->getAdminUser($uid);
            $this->assign('data', $data);
        }
        $groupModel = D('Admin/Group');
        $group = $groupModel->getGroup();
        $this->assign('uid', $uid);
        $this->assign('group', $group);
        $this->render();
    }
}