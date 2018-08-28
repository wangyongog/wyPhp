<?php
namespace App\Controller;
use WyPhp\DB;

class log extends baseController {
    protected $params = ['prefix' =>'log_'];
    public function actionIndex(){
        $where = [];
        if(I('ltype')){
            $where['ltype'] = I('ltype');
        }
        $this->count = DB::count('error', $where, $this->params);
        $data = DB::fetch_all('error','*',$where, 'id DESC',$this->limit,$this->page,'','',$this->params);
        $this->pageBar();
        $this->assign('data', $data);
        $this->render();
    }
    public function actionDel(){
        $id = I('id','int',0);
        $token = I('token');
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('error',array('id'=>$id), $this->params)){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
}