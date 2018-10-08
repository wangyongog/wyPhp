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
         if(!$this->auth()){
             $this->error('无权操作！');
         }
         $this->getMem();
         list($act, $par) = explode('?', $_SERVER['REQUEST_URI']);
         $this->assign('act', rtrim($act, F('URL_HTML_FIX')));
         //$this->assign('act','/'.CONTROLLER.'/'.ACTION);
         $this->assign('user',$this->admin);
     }

    /**
     * 权限验证
     * @return bool
     */
    protected function auth(){
         if(!in_array($this->admin['uid'], F('SYSTEM_USERID')) ){
             $group = D('Admin/Group');
             return $group->check(CONTROLLER.'/'.ACTION, $this->admin['uid']);
         }
         return true;
    }

    /**
     * 获取栏目列表
     *
     */
    protected function getMem(){
        $sidebarlist = S('sidebarlist'.$this->admin['uid']);
        $sidebar = new SidebarModel();
        if(empty($sidebarlist)){
            $sidebarlist = $sidebar->sidebarList($this->admin['uid']);
        }
        $this->assign('head_itle', $sidebar->getHeadTitle());
        $this->assign('sidebarlist', $sidebarlist);
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
                 $manager = D('Admin/Manager');
                 $user = $manager->checkLogin($uid);
                 if ($user && $user['hash'] == $hash) {
                     $this->admin = $user;
                 }else{
                     session('uidHahs',null);
                 }
             }
         }
     }
     protected function showMsg($msg){
         //$this->assign('msg', $msg);
         //$this->render('public/msg.html');
         $html = '<script>document.getElementsByClassName("page-content").innerHTML = "ssssssssss";</script>';
         //echo $html;
         die($html);
     }
}