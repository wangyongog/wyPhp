<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;
class links extends baseController{
    public function actionIndex(){
        $this->count = DB::count('links', []);
        $data = DB::fetch_all('links','*',[], 'sort desc,id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        $id = G('id','int',0);
        if(IS_AJAX && IS_POST){
            $data = Filter::$gp['data'];
            if(!$data['title']){
                $this->error('请输入名称！');
            }

            if($id){
                if(!DB::update('links', $data,['id'=>$id])){
                    $this->error('编辑失败');
                }
            }else{
                $data['addtime'] = TIMESTAMP;
                if(!DB::insert('links', $data)){
                    $this->error('添加失败');
                }
            }
            $this->success('操作成功');
        }
        if($id){
            $data = DB::fetch_first('links','*',['id'=>$id]);
            $this->assign('data', $data);
        }
        $this->render();
    }
    public function actionDel(){
        $id = G('ids');
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('links', ['id'=>['in',$id]])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
}