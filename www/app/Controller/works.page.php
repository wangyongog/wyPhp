<?php
namespace App\Controller;
use WyPhp\DB;
class works extends baseController {
    public function actionIndex(){
        if(IS_AJAX){
            $typeid = G('id','int',0);
            if($typeid){
                //$this->limit = 1;
                $archivesModel = D('Archives');
                $this->count = DB::count('archives', ['typeid'=>$typeid]);
                $data = $archivesModel->getlist('arid,description,url,thumb,title,addtime',['typeid'=>$typeid],'weight desc',$this->limit,$this->page);
                $this->assign('data',$data);
                $this->assign('typeid',$typeid);
                $this->assign('post_url',U('/works'));
                $this->tbody_html = $this->fetch('works/list.html');
                $this->dynamicOutPrint('public/page/ajax_page.html');
            }
        }
        $menusModel = D('Menus');
        $menus_title = $menusModel->getlist('typeid,typename', ['pid'=>8],'weight asc');
        $this->assign('menus_title', $menus_title);
        $this->render();
    }

}