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
            $stype = G('stype');
            $data['sitename'] = G('sitename');

            $data['keywords'] = G('keywords');
            $data['description'] = G('description');
            $data['nums'] = Filter::$gp['nums'];

            foreach ($data as $k => $v) {
                DB::update('setting',array('value' =>$v ? serialize($v) : '' ),array('k'=>$k,'type'=>$stype)) ;
            }
            S('setting'.$stype ,serialize($data),3600*5);
            $this->success('提交成功！');
            die();
        }
        $set = D('aceAdmin/Setting');
        $data = $set->get_setting('', 'all');
        $this->assign('web_name',CF('WEB_NAME'));
        $this->assign('data', $data);
        $this->render();
    }
}