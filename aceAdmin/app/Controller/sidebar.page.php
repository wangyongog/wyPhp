<?php
namespace App\Controller;
use aceAdmin\Model\SidebarModel;
use WyPhp\DB;

class Sidebar extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            $sidebarModel = new SidebarModel();
            $data = getTree($sidebarModel->getAll());
            $html_row = $this->menList($data);
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    protected function menList($data, $step=0){
        static $html_row = '';
        if(!empty($data)){
            foreach ($data as $k => $val){
                $bold = $step ? '' : 'style="font-weight: bold"';
                $html_row .= '<tr>
                        <td class="center"><label class="pos-rel"><input id="ids" name="ids[]" value="'.$val['id'].'" type="checkbox" class="ace ids"><span class="lbl"></span></label></td>
                        <td '.$bold.'>'.str_repeat('&nbsp;&nbsp;', $step) .($step ? '┗━':'') .$val['title'].  '</td>
                        <td class="hidden-480">' . $val['url'].  '</td>
                        <td><i class="'.$val['icon'].'"></i></td>
                        <td>' . ($val['status'] ==1 ? '开启':'关闭' ).  '</td>
                        <td class="hidden-480">' . $val['o'].  '</td>
                        <td><a href="javascript:;" _url="'.U('sidebar/add',array('id'=>$val['id'],'token'=>creatToken($val['id']))).'" class="edit">编辑</a> | <a href="javascript:;" _url="'.U('sidebar/del',array('id'=>$val['id'],'token'=>creatToken($val['id']))).'" class="del">删除</a></td>
                    </tr> ';
                if(!empty($val['children'])){
                    $this->menList($val['children'],$step+3);
                }
            }
        }
        return $html_row;
    }
    public function actionAdd(){
        $sidebar = new SidebarModel();
        $id = G('id','int',0);
        if(IS_AJAX){
            if(!G('title')){
                $this->error('栏目名不能为空！');
            }
            $data['pid'] = G('pid','int',0);
            $data['url'] = G('url');
            $data['title'] = G('title');
            $data['icon'] = G('icon');
            $data['status'] = G('status') ? 1 : 2;
            $data['o'] = G('order');
            $data['tips'] = G('tips');
            $msg = '添加成功！';

            if($id){
                $row = $sidebar->update($data, ['id'=>$id]);
                $msg = '编辑成功！';
            }else{
                $id = $sidebar->add($data);
            }
            if($id || $row){
                $this->outData['reload'] = 1;
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
        $this->assign('sidebarlist', getTree($sidebar->getAll()));
        $this->render();
    }
    public function actionDel(){
        $id = G('id','int',0);
        $token = G('token');
        $ids = GetSonIds($id);
        if(!$id || $token !=creatToken($id) && $ids){
            $this->error('无效操作！');
        }
        $items = DB::fetch_all('auth_rule' ,'id,pid',[] ,'o ASC');
        if(DB::delete('auth_rule',array('id'=>['in',$ids]))){
            $this->outData['reload'] = 1;
            $this->success('操作成功!');
        }
        $this->error('删除失败！');
    }
}