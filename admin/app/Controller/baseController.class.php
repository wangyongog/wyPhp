<?php
namespace App\Controller;
use Admin\Model\SidebarModel;
use WyPhp\Controller;
use WyPhp\DB;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 15:28
 */
class baseController extends Controller {
     public $admin = [];
     public function _initialize(){
         $this->_checkLogin();
         if (in_array(CONTROLLER, ['login'])) {
             if($this->admin){
                 redirect('/main');
             }
             return true;
         }
         if(!$this->admin){
             redirect(U('/login'));
         }
         $sidebarlist = S('sidebarlist');
         if(empty($sidebarlist)){
             $sidebar = new SidebarModel();
             $sidebarlist = $sidebar->sidebarList();
             S('sidebarlist' ,$sidebarlist);
         }
         $this->assign('user',$this->admin);
         $this->assign('sidebarlist', $sidebarlist);
         $this->assign('web_name', get_map());
     }

    /**
     * 验证用户登录
     *
     */
    private function _checkLogin(){
         $uidHash = session('uidHahs');
         if($uidHash){
             list($uid, $hash) = explode("\t", mcrypt($uidHash, 'DECODE')  ,2);
             $uid = intval($uid);
             if($uid && $hash){
                 $user = DB::fetch_first('admin', 'uid,groupid,user,hash,lasttime,addtime', array('uid' =>$uid));
                 if ($user && $user['hash'] == $hash) {
                     $this->admin = $user;
                 }else{
                     session('uidHahs',null);
                 }
             }
         }
     }
}