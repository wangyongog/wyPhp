<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 14:38
 */
namespace App\Controller;

use Common\Model\BalanceModel;
use WyPhp\DB;

class pay extends baseController{
    public function actionIndex(){
        $money = sprintf("%.2f",I('money', 'float'));
        $epayid = I('payid');
        $payid = I('payid', 'int');
        $alipay_number = I('alipay_number');
        $formhash = I('formhash');
        file_put_contents(ROOT.'/data/pay.txt',date('Y-m-d H:i:s').'  '. getIP(). ' | '. $money.' | '. $payid.' | '.' '.$epayid.NL,FILE_APPEND);
        if($money && $payid && $formhash == substr(md5($money.$payid.substr(F('AUTOKEY'),16,19)),8)){
            file_put_contents(ROOT.'/data/pay.txt',date('Y-m-d H:i:s').'  '. getIP(). ' aa '.NL,FILE_APPEND);
            $diftime = TIMESTAMP - 600;
            //$pdata = DB::fetch_first('payid', '*',array('pid' =>$payid,'isuse'=>0,'money' =>$money,'addtime'=>array('egt', $diftime)), 'pid DESC');
            $pdata = DB::fetch_first('payid', '*',array('pid' =>$payid,'money' =>$money), 'pid DESC');
            if(!empty($pdata)){
                if($pdata['isuse'] == 0 && $pdata['addtime'] >=$diftime){//正常充值
                    if(BalanceModel::leftmoney($pdata['uid'], $pdata['money'],'充值',1)){
                        DB::update('payid',array('isuse'=>1), array('pid'=>$payid));
                        file_put_contents(ROOT.'/data/pay.txt',date('Y-m-d H:i:s'). ' '. $money.' | '. $payid.' | ok'.NL,FILE_APPEND);
                        edie(md5(time()));
                    }
                }
                if($pdata['isuse'] == 0 && $pdata['addtime'] <$diftime){//超时充值
                    $data['pid'] = $payid;
                    $data['epayid'] = $epayid;
                    $data['money'] = $money;
                    $data['addtime'] = TIMESTAMP;
                    DB::insert('payerroy', $data);
                    edie();
                }
            }
            edie('无效操作！');
        }else{
            edie('无效操作！');
        }
    }
    public function actionErro(){
        $money = sprintf("%.2f",I('money', 'float'));
        $payid = I('payid', 'int');
        $formhash = I('formhash');
        $epayid = I('payid');
        if($money>1 && $formhash == substr(md5($money.$payid.substr(F('AUTOKEY'),16,19)),8)){
            $data['pid'] = $payid;
            $data['epayid'] = $epayid;
            $data['money'] = $money;
            $data['addtime'] = TIMESTAMP;
            DB::insert('payerroy', $data);
        }
    }
}