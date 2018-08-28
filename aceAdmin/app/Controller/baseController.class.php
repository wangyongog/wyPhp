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
         // ajax 信息输出 处理
         $this->outData['append'] = [];     // 追加
         $this->outData['html'] = [];       // 替换内容
         $this->outData['remove'] = [];     // 删除
         $this->outData['data'] = '';            // 方法中的数据
         $this->outData['runFunction'] = '';            // 方法中的数据
         $this->outData['method'] = 'write';     // write需要写入    alert 只做提示
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
         $sidebar = new SidebarModel();
         if(empty($sidebarlist)){
             $sidebarlist = $sidebar->sidebarList();
         }
         $this->assign('head_itle', $sidebar->getHeadTitle());
         list($act, $par) = explode('?', $_SERVER['REQUEST_URI']);
         $this->assign('act', rtrim($act, F('URL_HTML_FIX')));
         //$this->assign('act','/'.CONTROLLER.'/'.ACTION);
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