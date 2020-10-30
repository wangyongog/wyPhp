<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;
class member extends baseController{
    public function actionIndex(){
        $where = [];
        if(G('name')){
            $where['name'] = ['like','"%'.G('name').'%"'];
        }
        if(G('phone')){
            $where['phone'] = ['like','"%'.G('phone').'%"'];
        }
        $this->count = DB::count('member', $where);
        $data = DB::fetch_all('member','*',$where, 'uid DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        $id = G('uid','int',0);
        if(IS_AJAX){
            $data = Filter::$gp['data'];
            if(!$data['name']){
                $this->error('请输入名称！');
            }
            $data['start_time'] = $data['start_time'] ? strtotime($data['start_time']) : 0;
            $data['end_time'] = $data['end_time'] ? strtotime($data['end_time']) : 0;
            if($id){
                if(!DB::update('member', $data,['uid'=>$id])){
                    $this->error('编辑失败');
                }
            }else{
                $data['addtime'] = TIMESTAMP;
                if(!DB::insert('member', $data)){
                    $this->error('添加失败');
                }
            }
            $this->success('操作成功');
        }
        if($id){
            $data = DB::fetch_first('member','*',['uid'=>$id]);
            $this->assign('data', $data);
        }
        $this->render();
    }
    public function actionDel(){
        $id = G('ids');
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('member', ['uid'=>['in',$id]])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
}