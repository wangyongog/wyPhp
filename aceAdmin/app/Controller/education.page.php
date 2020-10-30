<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;
class education extends baseController{
    public function actionIndex(){
        $this->count = DB::count('education', []);
        $data = DB::fetch_all('education','*',[], 'id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        $id = G('id','int',0);
        if(IS_POST){
            $data = Filter::$gp['data'];

            if(empty($data)){
                $this->error('请输入数据！');
            }


            if(!$id){

                if(DB::insert('education',$data)) {
                    $this->success('操作成功');
                }
            }else{
                if(DB::update('education',$data,['id'=>$id])){
                    $this->success('操作成功');
                }
            }
            $this->error('操作失败！');
        }
        if($id){
            $data = DB::fetch_first('education','*',['id'=>$id]);
            $this->assign('data', $data);
        }
        $this->render();
    }
    public function actionInfo(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        $this->count = DB::count('education_contents', ['eaid'=>$id]);
        $data = DB::fetch_all('education_contents','*',['eaid'=>$id], 'o desc,id DESC',$this->limit,$this->page);
        $data = array_map(function ($val){
            $val['contents'] = unserialize($val['contents']);
            return $val;
        },$data);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }
    public function actionAddinfo(){
        $eaid = G('eaid','int',0);
        $id = G('id','int',0);
        if(IS_POST){
            $data = Filter::$gp['data'];
            if(!$eaid){
                $this->error('无效提交！');
            }
            if(empty($data)){
                $this->error('请输入数据！');
            }
            $idata['contents'] = serialize($data);
            $idata['o'] = G('o');
            if(!$id){
                $idata['eaid'] = $eaid;
                $idata['addtime'] = TIMESTAMP;
                if(DB::insert('education_contents',$idata)) {
                    $this->success('操作成功');
                }
            }else{
                if(DB::update('education_contents',$idata,['id'=>$id])){
                    $this->success('操作成功');
                }
            }
            $this->error('操作失败！');
        }
        if($id){
            $data = DB::fetch_first('education_contents','contents,o',['id'=>$id]);
            $contents_arr = $data['contents'] ? unserialize($data['contents']) : [];
            $this->assign('data',array_merge($data,$contents_arr) );
        }
        $this->render();
    }
    public function actionDelinfo(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('education_contents', ['id'=>$id])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
    public function actionDel(){
        $id = G('id','int',0);
        if(!$id){
            $this->error('无效操作！');
        }
        if(DB::delete('education', ['id'=>$id])){
            DB::delete('education_contents', ['eaid'=>$id]);
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }
}