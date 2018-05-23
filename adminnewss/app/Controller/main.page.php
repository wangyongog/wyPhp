<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 14:38
 */
namespace App\Controller;

use WyPhp\DB;

class main extends baseController{
    public function actionIndex(){
        $data = DB::fetch_all('notice','*', ['map'=>1], 'id DESC', 30,$this->page);
        $this->assign('data',$data);
        $this->render();
    }
    public function actionReply(){
        if(IS_AJAX){
            $where['uid'] = $this->uid;
            $this->count = DB::count('feedback' ,$where);
            $data = DB::fetch_all('feedback','*', $where, 'id DESC', $this->limit, $this->page);
            $html_row = '';
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td>'.$val['notice'].'</td>
                        <td>'.$val['reply'].'</td>
                        <td>'.date('Y-m-d H:i', $val['create_time']) .'</td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionPost(){
        if(IS_AJAX){
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            if(!I('content')){
                $this->error('请输入反馈内容！');
            }
            $data['uid'] = $this->uid;
            $data['notice'] = I('content');
            $data['create_time'] = TIMESTAMP;
            if(DB::insert('feedback', $data)){
                $this->success('提交成功！');
            }
            $this->error('提交失败！');
        }
    }
}