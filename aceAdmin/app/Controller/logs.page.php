<?php
namespace App\Controller;
use WyPhp\DB;
class logs extends baseController{
    public function actionIndex(){
        $this->count = DB::count('error', [],['prefix'=>'log_']);
        $data = DB::fetch_all('error','*',[], 'id DESC',$this->limit,$this->page,'','',['prefix'=>'log_']);
        $this->pageBar();
        $this->assign('data', $data);
        $this->render();
    }

    public function actionDel(){
        $id = G('ids');
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('error', ['id'=>['in',$id]],['prefix'=>'log_'])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
}