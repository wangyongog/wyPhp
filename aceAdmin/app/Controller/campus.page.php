<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class campus extends baseController{
    public function actionIndex(){
        $where = [];
        $this->count = DB::count('campus', $where);
        $data = DB::fetch_all('campus','*',$where, ' o desc,id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        $id = G('id','int',0);
        if(IS_AJAX && IS_POST){
            $data = Filter::$gp['data'];
            if(!G('fileup1')){
                $this->error('请选择图片！');
            }
            $data['img'] = G('fileup1');

            if($id){
                if(!DB::update('campus',$data,['id'=>$id])){
                    $this->error('编辑失败！');
                }
            }else{

                if(!DB::insert('campus',$data)){
                    $this->error('添加失败！');
                }
            }
            $this->success('操作成功');
        }
        if($id){
            $data = DB::fetch_first('campus','*',['id'=>$id]);
            $this->assign('data', $data);
        }
        $this->render();
    }


    public function actionDel(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete(['id'=>$id])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }

}