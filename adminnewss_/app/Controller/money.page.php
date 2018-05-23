<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/9
 * Time: 15:30
 */

namespace App\Controller;
use Common\Model\BalanceModel;
use WyPhp\DB;
class money extends baseController{
    public function actionIndex(){
        $this->render();
    }
    public function actionPay(){
        $moeny = I('money', 'float');
        if(check_formhash() === false){
            edie('无效操作！');
        }
        if($moeny<1){
            edie('最低充值不能低于1元！');
        }
        if(!$payid = BalanceModel::addPayId($moeny)){
            edie('请求出错！');
        }
        $this->assign('payid', '0000'.$payid);
        $this->assign('money', $moeny);
        $this->render();
    }
    public function actionTips(){
        $this->render();
    }
    public function actionList(){
        $type = I('type', 'int');
        if($type){
            $where['type'] = $type;
        }
        $balance = D('Balance');
        $where['uid'] = $this->uid;
        $this->count = DB::count('balance' ,$where);
        $data = DB::fetch_all('balance','*', $where, 'id DESC', $this->limit, $this->page);
        $this->assign('data', $data);
        $this->assign('stype', $balance->stype);
        $this->pageBar();
        $this->render();
    }
}