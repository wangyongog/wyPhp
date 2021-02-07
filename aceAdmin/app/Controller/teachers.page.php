<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class Teachers extends baseController{
    public function actionIndex(){
        $where = [];

        $this->count = DB::count('teachers', $where);
        $data = DB::fetch_all('teachers','*',$where, 'id DESC',$this->limit,$this->page);
        if($data){
            $data = array_map(function ($val){
                $val['img'] = $val['img'] ? explode(',', $val['img']) : [];
                return $val;
            },$data);
        }
        $this->pageBar();

        $this->assign('data', $data);

        $this->render();
    }
    public function actionAdd(){
        $id = G('id','int',0);
        if(IS_POST){
            $data = Filter::$gp['data'];
            if(!$data['title']){
                $this->error('请输入姓名！');
            }
            $files = Filter::$gp['files'];
            if(!$files){
                $this->error('请选择图片！');
            }
            $data['img'] = implode(',',$files);
           // $data['is_index'] = G('status') == 'on' ? 1 : 0;
            if($id){
                if(!DB::update('teachers',$data,['id'=>$id])){
                    $this->error('操作失败');
                }
            }else{
                $data['addtime'] = TIMESTAMP;
                if(!DB::insert('teachers',$data)){
                    $this->error('操作失败');
                }
            }
            $this->success('操作成功');
        }
        if($id){
            $data = DB::fetch_first('teachers','*',['id'=>$id]);
            $data['img'] = $data['img'] ? explode(',',$data['img']) : [];
            $this->assign('data', $data);
        }

        $this->render();
    }


    public function actionDel(){
        $id = G('ids');
        if(!$id){
            $this->error('无效操作！');
        }
        if( DB::delete('teachers',['id'=>['in',$id]])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }

}