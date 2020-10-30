<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class works extends baseController{
    public function actionIndex(){
        //echo picSize('attaches/20191227/small_d2ee1a8b431c4739984bb83bc809bcb4.jpg#img2');exit;
        $where = [];
        if(G('type')){
            $where['type'] = G('type');
        }
        $pos = DB::fetch_all('works_type','*');
        foreach ($pos as $v){
            $pos_arr[$v['id']] = $v['name'];
        }
        $this->count = DB::count('works', $where);
        $data = DB::fetch_all('works','*',$where, 'sort desc,id DESC',$this->limit,$this->page);
        $this->pageBar();
        $data = array_map(function ($val){
            $val['img'] = $val['img'] ? unserialize($val['img']) : [];
            return $val;
        }, $data);

        $this->assign('data', $data);
        $this->assign('pos_arr', $pos_arr);
        $this->render();
    }
    public function actionAdd(){
        $id = G('id','int',0);
        if(IS_POST){
            $data = Filter::$gp['data'];
            if(!$data['type']){
                $this->error('请选择作品类别！');
            }
            $img = Filter::$gp['files'];
            if(!$img){
                $this->error('请选择图片！');
            }
            $data['img'] = is_array($img) ? serialize($img) : $img;
            if($id){
                if(!DB::update('works',$data,['id'=>$id])){
                    $this->error('编辑失败');
                }
            }else{
                $data['addtime'] = TIMESTAMP;
                if(!DB::insert('works',$data)){
                    $this->error('添加失败！');
                }
            }
            $this->success('操作成功');
        }
        if($id){
            $data = DB::fetch_first('works','*',['id'=>$id]);
            $data['img'] = $data['img'] ? unserialize($data['img']) : [];
            $this->assign('data', $data);
        }
        $pos = DB::fetch_all('works_type','*',[], 'sort desc,id DESC');
        $this->assign('pos', $pos);
        $this->render();
    }


    public function actionDel(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('works',['id'=>$id])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
    public function actionTypelist(){
        $data = DB::fetch_all('works_type','*',[], 'sort desc,id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }
    public function actionTypeadd(){
        $id = G('id','int',0);
        if(IS_POST){
            $data = Filter::$gp['data'];
            if(!$data['name']){
                $this->error('请输入名称！');
            }
            if($id){
                if(!DB::update('works_type',$data,['id'=>$id])){
                    $this->error('编辑失败');
                }
            }else{
                if(!DB::insert('works_type',$data)){
                    $this->error('添加失败！');
                }
            }
            $this->success('操作成功');
        }
        if($id){
            $data = DB::fetch_first('works_type','*',['id'=>$id]);
            $this->assign('data', $data);
        }

        $this->render();
    }
    public function actionDeltype(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('works_type',['id'=>$id])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
}