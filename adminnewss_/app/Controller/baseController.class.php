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
         $this->assign('setConfig', $setConfig[1]);
         if (in_array(CONTROLLER, ['login'])) {
             if($this->uid){
                 redirect('/main');
             }
             return true;
         }
         if(!$this->uid){
             redirect(U('/login'));
         }
         $this->assign('taskshow', $setConfig[1]['taskshow']);

         $this->assign('menu_types', F('TASK_TYPE'));
         $this->assign('act',CONTROLLER.'/'.ACTION);
         $this->assign('user', $this->user);
         $this->assign('headTask', $this->_getTask());
         $this->assign('headReply', D('reply')->getList(['uid' =>$this->uid,'isnew'=>1],'*' ,5,1));
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
     private function _getTask(){
         $taskModel = D('Task');
         $where['status'] = array('in',[0,1]);
         $where['uid'] = $this->uid;
         $ndata = [];
         $data = $taskModel->getList($where , '`type`,title,kscount,dqcount,count,status', 10,1,'status DESC,tid DESC');
         if(!empty($data)){
             foreach ($data as $k=>$v){
                 $v['title'] = urldecode($v['title']);
                 $ndata['jx'] += $v['status'] ==1 ? 1 : 0;
                 $ndata['dd'] += $v['status'] ==0 ? 1 : 0;
                 $v['jindu'] = getdzpren($v['kscount'], $v['dqcount'], $v['count'],true);
                 if($v['type']== 'gaosu'){
                     $v['type'] = 'task';
                 }
                 $ndata['list'][$k] = $v;
             }
             unset($data);
         }
         return $ndata;
     }
}