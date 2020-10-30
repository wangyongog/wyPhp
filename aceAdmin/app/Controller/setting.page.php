<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class setting extends baseController {

    public function actionIndex(){
        if(IS_POST){
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            $data = Filter::$gp['data'];
            DB::update('setting',array('value' =>$data ? serialize($data) : '' ),array('k'=>'website')) ;
            S('setting' ,null);
            $this->success('提交成功！');
            die();
        }
        $set = D('aceAdmin/Setting');
        $data = $set->get_setting('website');

        $this->assign('data', unserialize($data['value']) );
        $this->render();
    }
}