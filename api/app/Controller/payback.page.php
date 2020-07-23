<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class payback extends baseController {
    public function actionAlipay(){
        file_put_contents('./alipay_back.txt', print_r($_POST,true), FILE_APPEND);
        try{
            //交易状态
            $trade_status = G('trade_status');
            if($trade_status != 'TRADE_FINISHED' && $trade_status != 'TRADE_SUCCESS') {
                throw new \Exception('无效交易');
            }
            require_once(FWPATH . '/plugins/Tools/alipay-sdk/aop/AopClient.php');
            $aop = new AopClient();

            foreach (Filter::$gp as $key=> $val){
                $params[$key] = urldecode($val);
            }

            $aop->alipayrsaPublicKey = file_get_contents(SConstant::$alipay_config['rsa_public']);
            if(!$aop->rsaCheckV1(Filter::$gp, '', 'RSA2')){
                throw new Exception('验签失败');
            }
            //验证是否存在
            $out_trade_no = empty( $params['out_trade_no']) ? 0 : (int)$params['out_trade_no'];
            if(!$out_trade_no){
                throw new \Exception('out_trade_no不存在');
            }
            $paymentsModel = new Model_fi_payments();
            $payments = $paymentsModel->getOne('payments_id='.$out_trade_no.' AND status<>1 AND succeed_time=0 AND payway_id=1');
            if(!$payments){
                throw new Exception('无效订单');
            }
            if($params['trade_no'] != $payments['trade_no']){
                throw new Exception('支付单号错误');
            }
            if($params['app_id'] != SConstant::$alipay_config['app_id']){
                throw new Exception('无效商户ID');
            }
            if(bccomp($params['total_amount'], $payments['amount'],2) !=0 ){
                throw new Exception('金额不一致');
            }
            $bankServ = new Service_banks();
            $flag = $bankServ->processPayBack2($payments['payments_id'], $params['trade_no'], $params['total_amount']);

            if (!$flag) {
                throw new \Exception();
            }

            switch ($payments['payments_type']){
                //逻辑处理
            }
            echo 'success';exit;
        }catch (\Exception $e) {
            file_put_contents('./alipay_error.txt', $e->getMessage(), FILE_APPEND);
        }
    }
}