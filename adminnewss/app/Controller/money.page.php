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
    public function actionPostalipay(){
        if(check_formhash()===false){
            $this->error('页面过期，请重新提交！');
        }
        $data['alipay_number'] = trim(I('alipay_number','')) ;
        $data['cost'] = floatval(I('moeny')) ;
        if($data['cost']<0){
            $this->error('金额不能小于0！');
        }

        if(!is_numeric($data['alipay_number']) ){
            $this->error('订单号只能是数字！');
        }
        if(!$data['alipay_number'] || !$data['cost']){
            $this->error('请输入订单号或金额');
        }

        if(DB::fetch_first('recharge','id', array('alipay_number'=>$data['alipay_number'],'uid'=>$this->uid)) ){
            $this->error('订单号不能重复提交！');
        }
        $data['create_time'] = TIMESTAMP;
        $data['uid'] = $this->uid;
        $data['username'] = $this->user['username'];
        if(DB::insert('recharge', $data)){
            $this->success('提交成功！',U('Money/recharge'));
            die();
        }
        $this->error('提交失败');
        die();

    }
    public function actionRecharge(){
        $where['uid'] = $this->uid;
        if(I('status', 'int')){
            $where['status'] = I('status','int');
        }
        $this->count = DB::count('recharge',$where);
        $data = DB::fetch_all('recharge','*', $where,'id desc',$this->limit,$this->page);
        $this->assign('data', $data);
        $this->pageBar();
        $this->render();
    }
}