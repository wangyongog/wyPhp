<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class PaymentsModel extends Model {
    public $table = 'payments';
    /**
     * 支付宝小程序
     * @param $uid
     * @param $buyer_id
     * @param $order_id
     * @param $amount
     * @param string $type
     * @return array|bool
     */
    public function alipay($uid, $buyer_id, $order_id, $amount, $type = 'order', $subject='订单'){
        try{
            $amount = price_cut($amount);
            $payments_id = $this->initData($order_id, $uid, $amount, $type,'alipay');
            if (!$payments_id) {
                throw new \Exception($this->getError());
            }
            $pay_data = [
                'out_trade_no' =>$payments_id,
                'total_amount' =>$amount,
                'subject' =>$subject,
                'buyer_id' =>$buyer_id
            ];
            $res = $this->aliPayMini($pay_data);
            $paymentsModel = new Model_fi_payments();
            $paymentsModel->update(
                ['payments_id' =>$payments_id],
                [
                    'trade_no' =>isset($res['trade_no']) ? $res['trade_no'] : '',
                    'back_message' =>json_encode($res)
                ]
            );
            if($res['code'] !=10000){
                throw new \Exception($res['msg']);
            }
            return $res;
        }catch (\Exception $e) {
            $this->setError(-101, $e->getMessage());
            return false;
        }
    }
    /**
     * 创建支付记录
     *
     * @param mixed $order_id       订单ID
     * @param mixed $uid            用户UID
     * @param mixed $amount         支付金额
     * @param mixed $payway_id      支付ID
     * @param mixed $payments_type  类型    订单 支付支付充值 order  魅币充值charge
     * @return  boolean or int
     */
    public function initData($order_id,$uid,$amount,$payments_type, $payway){
        try{
            $order_id = intval($order_id);
            $uid = intval($uid);
            $amount = price_cut($amount);
            $payments_type = $payments_type;
            $payway_arr = CF('payway');
            if(!isset($payway_arr[$payway])){
                throw new \Exception('无效支付方式！');
            }

            if($uid < 1 || bccomp($amount,0,2) != 1){
                throw new \Exception('金额不能小于0');
            }

            $idata['order_id'] = $order_id;
            $idata['uid'] = $uid;
            $idata['amount'] = $amount;
            $idata['addtime'] = TIMESTAMP;
            $idata['status'] = 0;
            $idata['payments_type'] = $payments_type;

            $idata['succeed_time'] = 0;
            $idata['back_message'] = '';
            $idata['trade_no'] = '';
            $idata['payway'] = $payway;

            $payments_id = DB::insert($this->table, $idata,false, ['prefix' =>'pay_']);
            if(!$payments_id){
                return false;
            }
            return $payments_id;
        }catch (\Exception $e){
            $this->setError(-101, $e->getMessage());
            return false;
        }
    }
}