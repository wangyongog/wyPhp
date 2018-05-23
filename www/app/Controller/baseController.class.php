<?php
namespace App\Controller;
use WyPhp\Controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 15:28
 */
class baseController extends Controller {
     public $uid = 0;
     public $user = [];
     public function _initialize(){
         $this->_checkLogin();
         $set = D('Admin/Setting');
         $setConfig = $set->get_setting('', 'all');
         $this->assign('setConfig', $setConfig[0]);
         if (in_array(CONTROLLER, ['login'])) {
             if($this->uid){
                 redirect('/main');
             }
             return true;
         }
         if(!$this->uid){
             redirect(U('/login'));
         }
         $upnum = empty($setConfig[0]['upnum']) ? 10000 : $setConfig[0]['upnum'];
         define('UPNUM',$upnum);
         //$taskshow = $setConfig[0]['taskshow'] ;//$set->get_setting('taskshow', 0);

         $this->assign('taskshow', $setConfig[0]['taskshow']);

         $this->assign('menu_types', F('TASK_TYPE'));
         $this->assign('act',CONTROLLER.'/'.ACTION);
         $this->assign('user', $this->user);
     }

    /**
     * 验证用户登录
     *
     */
    private function _checkLogin(){
         $uidHash = session('uidMb');

         if($uidHash){
             list($uid, $hash) = explode("\t", mcrypt($uidHash, 'DECODE')  ,2);
             $uid = intval($uid);
             if($uid && $hash){
                 $userMode = D('Member');
                 $user = $userMode->member(array('uid'=>$uid,'status'=>1),'uid,hash,username,grade,price_config,lasttime,addtime,leftmoney,pid');
                 if ($user && $user['hash'] == $hash) {
                     \APP::$user = $this->user = $user;
                     \APP::$uid = $this->uid = $uid;
                 }
             }
         }
     }
}