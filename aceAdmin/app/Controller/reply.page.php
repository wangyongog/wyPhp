<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 17:01
 */
namespace App\Controller;

use WyPhp\DB;

class reply extends baseController {
    public function actionIndex(){
        if(IS_AJAX){
            $replyModel = D('reply');
            $where = [];
            if(I('username')){
                $where['username'] = I('username');
            }
            $this->count = DB::count('feedback', $where);
            $data = $replyModel->getList($where,'*' ,$this->limit, $this->page, 'isnew DESC,id DESC');
            $html_row = '';
            $grade = F('TASK_GRADE');
            if($data){
                $member = D('Member');
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td><input type="checkbox" class="ids" name="ids[]" value="'.$val['id'].'" ></td>
                        <td>'.$val['notice'].'</td>
                        <td>'.$member->getUsername($val['uid']).'</td>
                        <td>'.$val['reply'].'</td>
                        <td>'.date('Y-m-d H:i:s', $val['create_time']) .'</td>
                        <td><a href="javascript:;" onclick="adminJs.showIframe(\'回复\',\''.U('reply/add',array('id'=>$val['id'])).'\',\'700\',\'550\')">回复</a> </td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionAdd(){
        $id = I('id','int',0);
        if(IS_AJAX){
            $reply = I('reply');
            if(check_formhash() === false || !$id){
                $this->error('无效操作！');
            }
            if(!$reply){
                $this->error('请输入内容！');
            }
            if(DB::update('feedback', ['reply' =>$reply,'replyuid' =>$this->admin['uid'], 'isnew' =>1],['id' =>$id])){
                $this->success('添加成功！',U('/reply'));
            }
            $this->error('添加失败！');
        }
        $notice = DB::result_first('feedback','notice',['id'=>$id]);
        $this->assign('notice', $notice);
        $this->assign('id', $id);
        $this->render();
    }
    public function actionNotadd(){
        $id = I('id','int',0);
        if(IS_AJAX){
            $notice = I('notice');
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            if(!$notice){
                $this->error('请输入内容！');
            }
            if($id){
                if(DB::update('notice', ['notice' =>$notice,'map' =>I('map','int',0),'douid' =>$this->admin['uid']],['id' =>$id])){
                    $this->success('编辑成功！',U('/reply/notice'));
                }
            }else{
                $data['addtime'] = TIMESTAMP;
                $data['douid'] = $this->admin['uid'];
                $data['notice'] = I('notice');
                $data['map'] = I('map','int',0);
                if(DB::insert('notice', $data)){
                    $this->success('添加成功！',U('/reply/notice'));
                }
            }

            $this->error('添加失败！');
        }
        $notice = DB::fetch_first('notice','notice,map',['id'=>$id]);
        $this->assign('data', $notice);
        $this->assign('id', $id);
        $this->render();
    }
    public function actionNotice(){
        if(IS_AJAX){

            $where = [];
            $mapArr = get_map();
            $this->count = DB::count('notice', $where);
            $data = DB::fetch_all('notice','*',$where,'id DESC' ,$this->limit, $this->page);
            $html_row = '';
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td><input type="checkbox" class="ids" name="ids[]" value="'.$val['id'].'" ></td>
                        <td>'.$val['notice'].'</td>
                        <td>'.$mapArr[$val['map']].'</td>
                        <td>'.date('Y-m-d H:i:s', $val['addtime']) .'</td>
                        <td><a href="javascript:;" _url="'.U('reply/notadd',array('id'=>$val['id'],'token'=>creatToken($val['id']))).'" class="edit">编辑</a> | <a href="javascript:;" _url="'.U('reply/del',array('id'=>$val['id'],'token'=>creatToken($val['id']))).'" class="del">删除</a></td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionDel(){
        $id = I('id','int',0);
        $token = I('token');
        if(!$id || $token !=creatToken($id)){
            $this->error('无效操作！');
        }
        if(DB::delete('notice',array('id'=>$id))){
            $data['info'] = '操作成功！';
            $data['status'] = 1;
            $data['reload'] = 1;
            $this->printJson($data);
        }
        $this->error('删除失败！');
    }

}