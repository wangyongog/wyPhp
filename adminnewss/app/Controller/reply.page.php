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
        $replyModel = D('reply');
        $data = $replyModel->getList(['uid' =>$this->uid],'*' ,$this->limit, $this->page, 'isnew DESC,id DESC');
        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        if(IS_AJAX){
            $notice = I('notice');
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            if(!$notice){
                $this->error('请输入反馈内容！');
            }
            if(DB::insert('feedback', ['notice' =>$notice,'uid' =>$this->uid, 'create_time' =>TIMESTAMP])){
                $this->success('添加成功！',U('/reply'));
            }
            $this->error('添加失败！');
        }
        $this->render();
    }
    public function actionRead(){
        if(check_formhash() === false){
            return false;
        }
        DB::update('feedback',['isnew' =>0],['uid' =>$this->uid,'isnew' =>1]);
    }
}