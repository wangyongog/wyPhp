<?php
namespace WyPhp;
require_once(FWPATH . '/plugins/Tools/alipay-sdk/aop/AopClient.php');
require_once(FWPATH . '/plugins/Tools/alipay-sdk/aop/request/AlipayTradeCreateRequest.php');
class Alipay{

    /**
     * 支付宝小程序，统一收单交易创建接口
     * @param $data
     * @return array|bool
     */
    public function aliPayMini($data){
        $aop = new AopClient();
        $aop->appId = SConstant::$alipay_config['app_id'];
        $aop->rsaPrivateKeyFilePath = SConstant::$alipay_config['rsa_private'];

        $aop->alipayrsaPublicKey = file_get_contents(SConstant::$alipay_config['rsa_public']);

        $aop->signType = 'RSA2';

        $request = new AlipayTradeCreateRequest();
        try {
            if(empty($data)){
                throw new Exception('无效数据');
            }
            $data['total_amount'] = floatval($data['total_amount']);
            if(empty($data['total_amount'])){
                throw new Exception('请输入金额');
            }
            if(empty($data['out_trade_no'])){
                throw new Exception('订单号不能为空');
            }
            if(empty($data['buyer_id'])){
                throw new Exception('购买人不能为空');
            }
            $biz_data['out_trade_no'] = $data['out_trade_no'];
            $biz_data['total_amount'] = $data['total_amount'];
            $biz_data['subject'] = $data['subject'];
            $biz_data['buyer_id'] = $data['buyer_id'];
            $biz_data['buyer_logon_id'] = isset($data['buyer_logon_id']) ? $data['buyer_logon_id'] : '';

            $biz = json_encode($biz_data);
            $request->setNotifyUrl(SConstant::$alipay_config['notify_url']);
            $request->setBizContent($biz);
            $result = $aop->execute($request);

            $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
            $resultCode = $result->$responseNode->code;
            file_put_contents('./alipay.txt', print_r($result, true),FILE_APPEND);
            //成功
            if(!empty($resultCode)&&$resultCode == 10000){
                return [
                    'code' =>10000,
                    'trade_no' =>$result->$responseNode->trade_no,
                    'out_trade_no' =>$result->$responseNode->out_trade_no
                ];
            }
            return [
                'code' =>$resultCode,
                'msg' =>$result->$responseNode->sub_msg,
            ];
        }catch (Exception $e) {
            return [
                'code' =>-101,
                'msg' =>$e->getMessage(),
            ];
        }
    }
    /**
     * 支付宝小程序换取授权访问令牌
     * @param $code 授权码，用户对应用授权后得到
     * @param string $grant_type 值为authorization_code时，代表用code换取；值为refresh_token时，代表用refresh_token换取
     * @param string $refresh_token 	刷新令牌，上次换取访问令牌时得到。见出参的refresh_token字段
     * @return array
     */
    public function oauthToken($code, $grant_type='authorization_code', $refresh_token =''){
        try {
            if(empty($code)){
                throw new Exception('授权码不正确');
            }
            require_once(PLUGINS_DIR . '/tools/paytools/alipay-sdk/aop/request/AlipaySystemOauthTokenRequest.php');
            $aop = new AopClient();
            $aop->appId = SConstant::$alipay_config['app_id'];
            $aop->rsaPrivateKeyFilePath = SConstant::$alipay_config['rsa_private'];

            $aop->alipayrsaPublicKey = file_get_contents(SConstant::$alipay_config['rsa_public']);
            $aop->signType = 'RSA2';
            $request = new AlipaySystemOauthTokenRequest();

            $request->setGrantType($grant_type);
            $request->setCode($code);
            if($refresh_token){
                $request->setRefreshToken($refresh_token);
            }

            $result = $aop->execute($request);

            $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
            //$resultCode = $result->$responseNode->code;
            $user_id = $result->$responseNode->user_id;
            if(!empty($user_id)){
                return [
                    'user_id'=>$result->$responseNode->user_id,
                    'access_token'=>$result->$responseNode->access_token,
                    'expires_in'=>$result->$responseNode->expires_in,
                    'refresh_token'=>$result->$responseNode->refresh_token,
                    're_expires_in'=>$result->$responseNode->re_expires_in,
                ];
            }
            throw new Exception($result->$responseNode->sub_msg);
        }catch (Exception $e) {
            $this->setError(-101,$e->getMessage());
            return false;
        }
    }

    /**
     *支付宝退款
     * @throws Exception
     */
    public function alipayTradeRefund($data){
        try {
            if(empty($data['trade_no'])){
                throw new Exception('交易号不能为空');
            }
            $money = isset($data['refund_amount']) ? floatval($data['refund_amount']) : 0;
            if(!$money){
                throw new Exception('金额不能为空');
            }
            $money = SCalc::getMoney($money);
            require_once(PLUGINS_DIR . '/tools/paytools/alipay-sdk/aop/request/AlipayTradeRefundRequest.php');
            $aop = new AopClient();
            $aop->appId = SConstant::$alipay_config['app_id'];
            $aop->rsaPrivateKeyFilePath = SConstant::$alipay_config['rsa_private'];
            $aop->alipayrsaPublicKey = file_get_contents(SConstant::$alipay_config['rsa_public']);
            $aop->signType = 'RSA2';
            $request = new AlipayTradeRefundRequest();
            $request->setNotifyUrl(SConstant::$alipay_config['notify_url']);
            $biz_data = [
                'trade_no' =>$data['trade_no'],//支付宝交易号
                'refund_amount' =>$money,//退款金额
                'out_request_no' =>isset($data['out_request_no']) ? $data['out_request_no'] : SUtil::random(6,3),//标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
            ];
            //订单号
            if(isset($data['out_trade_no'])){
                $biz_data['out_trade_no'] = $data['out_trade_no'];
            }
            //退款原因
            if(isset($data['refund_reason'])){
                $biz_data['refund_reason'] = $data['refund_reason'];
            }
            if(isset($data['goods_detail'])){
                $biz_data['goods_detail'] = $data['goods_detail'];
            }

            $biz_data = json_encode($biz_data);
            $request->setBizContent($biz_data);
            $result = $aop->execute($request);

            $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
            $resultCode = $result->$responseNode->code;
            file_put_contents('./alipay_refund.txt', print_r($result, true),FILE_APPEND);
            if(!empty($resultCode)&&$resultCode == 10000){
                return true;
            }
            throw new Exception($result->$responseNode->sub_msg);
        }catch (Exception $e) {
            $this->setError(-101,$e->getMessage());
            return false;
        }
    }
}