<?php
namespace App\Controller;
use WyPhp\Controller;

class baseController extends Controller {
     public $uid = 0;
     public function _initialize(){
         $setting = D('aceAdmin/Setting');
         $websit = $setting->get_setting('','all');
         $this->assign('website', $websit[0]);
         $this->assign('web_hosts', CF('DOMAIN'));
         $menusModel = D('aceAdmin/Menus');
         $this->assign('menus', $menusModel->getAll(['stype'=>1,'ishide'=>1],'*',true));
     }
}