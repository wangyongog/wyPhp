<?php
namespace App;
use WyPhp\DB;
use WyPhp\Filter;

class menus extends baseController{
    public function actionHzlx(){
        if(IS_AJAX){
            $actwebsModel = D('aceAdmin/Menus');
            $data = $actwebsModel->getAll(['stype'=>1]);

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
                        <td class="center"><label class="pos-rel"><input id="ids" name="ids[]" value="'.$val['typeid'].'" type="checkbox" class="ace ids"><span class="lbl"></span></label></td>
                        <td '.$bold.'>'.str_repeat('&nbsp;&nbsp;', $step) .($step ? '┗━':'') .$val['typename'].  ' [id :'.$val['typeid'].']</td>
                        <td class="hidden-480">' . $val['url'].  '</td>

                        <td>' . ($val['ishide'] ==1 ? '显示':'隐藏' ).  '</td>
                        <td class="hidden-480">' . $val['weight'].  '</td>
                        <td>
                        <a href="'.U('archives/index',array('typeid'=>$val['typeid'],'stype'=>$val['stype'])).'">内容</a> |
                        <a href="javascript:;" _url="'.U('Menus/add',array('id'=>$val['typeid'],'token'=>creatToken($val['typeid']))).'" class="edit">编辑</a> | 
                        <a href="javascript:;" _url="'.U('Menus/del',array('id'=>$val['typeid'],'token'=>creatToken($val['typeid']))).'" class="del">删除</a>
                        
                        </td>
                    </tr> ';
                if(!empty($val['children'])){
                    $this->menList($val['children'],$step+3);
                }
            }
        }
        return $html_row;
    }
    public function actionAdd(){
        $actwebsModel = D('aceAdmin/Menus');
        $id = G('id','int',0);
        if(IS_AJAX){
            $data = Filter::$gp['data'];
            if(!$data['typename']){
                $this->error('栏目名不能为空！');
            }

            $data['ishide'] = $data['ishide'] ? 1 : 2;

            $msg = '添加成功！';

            if($id){
                $row = $actwebsModel->update($data, ['typeid'=>$id]);
                $msg = '编辑成功！';
            }else{
                $id = $actwebsModel->add($data);
            }
            if($id || $row){
                S('menus1',null);
                $this->outData['reload'] = 1;
                $this->success($msg);
            }
            $this->error('操作失败！');
        }
        if($id){
            $data = DB::fetch_first('menus','*', ['typeid'=>$id]);
            $this->assign('data', $data);
        }
        $pid = isset($data['pid']) ? $data['pid'] : 0;
        $this->assign('pid', $pid);
        $this->assign('id', $id);
        $this->assign('sidebarlist', $actwebsModel->getAll(['stype'=>1]));
        $this->render();
    }
    public function actionDel(){
        $id = G('id','int',0);
        $token = G('token');
        $ids = GetSonIds($id);
        if(!$id || $token !=creatToken($id) && $ids){
            $this->error('无效操作！');
        }
        $menusModel = D('aceAdmin/Menus');
        if($menusModel->del(array('typeid'=>['in',$ids]))){
            $this->outData['reload'] = 1;
            S('menus0',null);
            $this->success('操作成功!');
        }
        $this->error('删除失败！');
    }
}