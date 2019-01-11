<?php
namespace App\Controller;
use WyPhp\DB;
class teacher extends baseController {
    public function actionIndex(){
        $banner = D('Banner');
        $banner_arr = $banner->getlist('img,url,pos', ['pos' =>['in',[4]]],'o desc',10);

        $this->assign('banner_data',$banner_arr);

        $archivesModel = D('Archives');
        $where['typeid'] = 6;
        $this->count = DB::count('archives', $where);
        $this->limit =1;
        $arr = $archivesModel->getlist('arid,extend,title,thumb',$where,'weight desc,arid desc',$this->limit,$this->page);
        foreach ($arr as $k=> $v){
            $v['extend'] = $v['extend'] ? unserialize($v['extend']) : '';
            $sdata[$k] = $v;
        }
        $this->assign('data', $sdata);
        $this->pageBar([],'','public/page/page.html');
        $this->render();
    }
    public function actionView(){
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