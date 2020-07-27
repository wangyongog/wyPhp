<?php
namespace App;
use WyPhp\DB;
use WyPhp\Filter;

class user extends baseController{
    public function actionPretest(){
        $where = [];
        $this->count = DB::count('pretest', $where);
        $data = DB::fetch_all('pretest','*',$where, 'id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }
    public function actionReply(){
        $where = [];
        $this->count = DB::count('reply', $where);
        $data = DB::fetch_all('reply','*',$where, 'id DESC',$this->limit,$this->page);
        $this->pageBar();

        $this->assign('data', $data);
        $this->render();
    }

}