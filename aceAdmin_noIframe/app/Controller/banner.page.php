<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class banner extends baseController{
    public function actionIndex(){
        $where = [];
        if(G('pos')){
            $where['pos'] = G('pos');
        }

        $this->count = DB::count('banner', $where);
        $data = DB::fetch_all('banner','*',$where, 'id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->assign('pos', CF('POSITION'));
        $this->render();
    }
    public function actionAdd(){
        $id = G('id','int',0);
        if(IS_AJAX && IS_POST){
            $data = Filter::$gp['data'];
            if(!$data['pos']){
                $this->error('请选择广告位！');
            }
            if(!G('fileup1')){
                $this->error('请选择图片！');
            }
            $data['img'] = G('fileup1');

            $data['startime'] = $data['startime'] ? strtotime($data['startime']) : 0;
            $data['endtime'] =  $data['endtime'] ? strtotime($data['endtime']) : 0;
            $bannerModel = D('aceAdmin/Banner');
            if($id){
                if(!$bannerModel->edit($data,['id'=>$id])){
                    $this->error($bannerModel->getError());
                }
            }else{
                $data['addtime'] = TIMESTAMP;
                if(!$bannerModel->add($data)){
                    $this->error($bannerModel->getError());
                }
            }
            $this->success('操作成功');
        }
        if($id){
            $data = DB::fetch_first('banner','*',['id'=>$id]);
            $data['endtime'] = $data['endtime'] ? date('Y-m-d H:i:s',$data['endtime'])  : '';
            $data['startime'] = $data['startime'] ? date('Y-m-d H:i:s',$data['startime'])  : '';
            $this->assign('data', $data);
            $this->assign('id', $id);
        }

        $this->assign('pos', CF('POSITION'));
        $this->render();
    }


    public function actionDel(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        $bannerModel = D('aceAdmin/Banner');
        if($bannerModel->del(['id'=>$id])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }

}