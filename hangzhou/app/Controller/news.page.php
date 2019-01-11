<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class news extends baseController {
    public function actionIndex(){

    }
    public function actionList(){
        if(IS_AJAX){
            $typeid = G('id','int',0);
            if($typeid){
                $this->limit = 1;
                $archivesModel = D('Archives');
                $this->count = DB::count('archives', ['typeid'=>$typeid]);

                $data = $archivesModel->getlist('arid,description,url,thumb,title,addtime',['typeid'=>$typeid],'weight desc',$this->limit,$this->page);
                $this->assign('data',$data);
                $this->assign('typeid',$typeid);
                $this->assign('post_url',U('news/list'));
                $this->tbody_html = $this->fetch('news/listrow.html');
                $this->dynamicOutPrint('public/page/ajax_page.html');
            }
        }
        $menusModel = D('Menus');
        $menus_title = $menusModel->getlist('typeid,typename', ['pid'=>4],'weight asc');
        $this->assign('menus_title', $menus_title);
        $this->render();
    }

}