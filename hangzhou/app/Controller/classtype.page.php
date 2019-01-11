<?php
namespace App\Controller;

class classtype extends baseController {
    public function actionIndex(){
        $typeid = G('typeid','int',0);
        if(!$typeid){
            die('无效操作');
        }

        $menusModel = D('aceAdmin/Menus');
        $classlist = $menusModel->getAll(['stype'=>1,'ishide'=>1,'pid'=>7],'typename,typeid,pid',true);
        foreach ($classlist as $v){
            $typeids[] = $v['typeid'];
        }
        if(!in_array($typeid,$typeids)){
            die('无效操作');
        }
        $this->assign('id', $typeid);
        $this->assign('classlist', $classlist);
        if(IS_AJAX){
            $banner = D('Banner');
            $banner_arr = $banner->getlist('img,url,pos', ['pos' =>['in',[5]]],'o desc',1);

            $this->assign('banner', $banner_arr);
            $archivesModel = D('Archives');
            $arr = $archivesModel->getlist('extend,typeid',['typeid'=>['in',$typeids]]);
            if($arr){
                foreach ($arr as $v){
                    $data['extendlist'][$v['typeid']] = $v['extend'] ? unserialize($v['extend']) : '';
                }
            }
            $this->assign('data', $data);
            $this->outData['html']['tbody_data'] = $this->fetch('classtype/datalist.html');
            $this->success();
            die();
        }
        $this->render();
    }
}