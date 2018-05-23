<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 17:01
 */
namespace App\Controller;
use Admin\Model\SidebarModel;
use WyPhp\DB;

class Sidebar extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            //echo  U('sidebar/add?t=9',array('ss'=>1,'y'=>4));exit;
            //$x = $this->fetch('page/page.html');
            //$y = $this->fetch('public/footer.html');
            //$sidebar = new SidebarModel();
            //$this->limit =1;
            //$this->count = DB::count('auth_rule');
            //$data = DB::fetch_all('auth_rule' ,'*','','o ASC',$this->limit,$this->page);
            $data = S('sidebarlist');
            //print_r($data);exit;
            $html_row = '';
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td class="center"><input class="ids" name="ids[]" value="'.$val['id'].'" type="checkbox"></td>   
                        <td>'  .$val['title'].  '</td>
                        <td>' . $val['url'].  '</td>
                        <td><i class="'.$val['icon'].'"></i></td>
                        <td>' . ($val['status'] ==1 ? '开启':'关闭' ).  '</td>
                        <td>' . $val['o'].  '</td>
                        <td><a href="javascript:;" _url="'.U('sidebar/add',array('id'=>$val['id'],'token'=>creatToken($val['id']))).'" class="edit">编辑</a> | <a href="javascript:;" _url="'.U('sidebar/del',array('id'=>$val['id'],'token'=>creatToken($val['id']))).'" class="del">删除</a></td>
                    </tr> ';
                    if(isset($val['children'])){
                        foreach ($val['children'] as $v){
                            $html_row .= '<tr>
                                <td class="center"><input class="ids" name="ids[]" value="'.$v['id'].'" type="checkbox"></td>   
                                <td>&nbsp;&nbsp;┗━' .$v['title'].  '</td>
                                <td>' . $v['url'].  '</td>
                                <td><i class="'.$v['icon'].'"></i></td>
                                <td>' . ($v['status'] ==1 ? '开启':'关闭' ).  '</td>
                                <td>' . $v['o'].  '</td>
                                <td><a href="javascript:;" _url="'.U('sidebar/add',array('id'=>$v['id'],'token'=>creatToken($v['id']))).'" class="edit">编辑</a> | <a href="javascript:;" _url="'.U('sidebar/del',array('id'=>$v['id'],'token'=>creatToken($v['id']))).'" class="del">删除</a></td>
                            </tr> ';
                        }
                    }
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionAdd(){
        $sidebar = new SidebarModel();
        $id = I('id','int',0);
        if(IS_AJAX){
            $data['pid'] = I('pid','int',0);
            $data['url'] = I('url');
            $data['title'] = I('title');
            $data['icon'] = I('icon');
            $data['status'] = I('status') ? 1 : 2;
            $data['o'] = I('order');
            $data['tips'] = I('tips');
            $msg = '添加成功！';
            if($id){
                $row = $sidebar->update($data, ['id'=>$id]);
                $msg = '编辑成功！';
            }else{
                $id = $sidebar->add($data);
            }
            if($id || $row){
                S('sidebarlist',null);
                $this->success($msg);
            }
            $this->error('操作失败！');
        }
        if($id){
            $data = DB::fetch_first('auth_rule','*', ['id'=>$id]);
            $this->assign('data', $data);
        }
        $pid = isset($data['pid']) ? $data['pid'] : 0;
        $this->assign('pid', $pid);
        $this->assign('id', $id);
        $this->assign('sidebarlist', S('sidebarlist'));
        $this->render();
    }
    public function actionDel(){
        $id = I('id','int',0);
        $token = I('token');
        if(!$id || $token !=creatToken($id)){
            $this->error('无效操作！');
        }
        if(DB::delete('auth_rule',array('id'=>$id))){
            $data['info'] = '操作成功！';
            $data['status'] = 1;
            $data['reload'] = 1;
            $this->printJson($data);
        }
        $this->error('删除失败！');
    }
}