<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;
class join extends baseController{
    public function actionIndex(){
        $where = [];
        if(G('name')){
            $where['name'] = ['like','"%'.G('name').'%"'];
        }
        if(G('phone')){
            $where['phone'] = ['like','"%'.G('phone').'%"'];
        }
        $this->count = DB::count('join', $where);
        $data = DB::fetch_all('join','*',$where, 'id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }

    public function actionDel(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('join', ['id'=>$id])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
}