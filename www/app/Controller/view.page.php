<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class view extends baseController {
    public function actionIndex(){
        $arid = G('arid','int',0);
        if($arid){
            $archivesModel = D('Archives');
            $data = $archivesModel->getOne('ac.arid,ac.title,ac.keywords,ac.description,ac.click_num,ac.extend,at.article_body',['ac.arid'=>$arid]);
            if(!$data){
                exit('无效数据！');
            }
            $data['workslist'] = $data['extend'] ? unserialize($data['extend']) : '';

            $data['article_body'] = htmlspecialchars_decode($data['article_body']);
            $this->assign('data', $data);
            $this->render();
        }
    }
}