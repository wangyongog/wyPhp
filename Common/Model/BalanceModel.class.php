<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/28
 * Time: 17:19
 */

namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class BalanceModel extends Model {
    public $table = 'balance';
    public $stype = [
        1 =>'充值',
        2 =>'消费',
        3 =>'退款',
        8 =>'系统操作'
    ];

    /**
     * 获取单价
     * @param $uid
     * @param $type
     * @param $user_grade
     * @return float|int
     */
    static function get_member_price($uid , $type, $user_grade,$map =0){
        $member = D('Member');
        $price_config = $member->member(array('uid'=>$uid));
        if($prices=unserialize($price_config['price_config'])){
            if(isset($prices[$type]) && $prices[$type]>0){
                return floatval($prices[$type]) ;
            }
        }
        return self::get_price_config($type, $user_grade,$map);
    }
    public static function get_price_config($type,$user_grade, $map=0){
        $config = DB::result_first('setting','value', array('k'=>'price','type'=>$map));
        $config = unserialize($config);
        return empty($config[$type][$user_grade]) ? 0 : floatval($config[$type][$user_grade]) ;
    }

    /**
     * 获取消费
     * @param $price
     * @param $count
     * @return float|int
     */
    static function get_task_cost($price, $count){
        return ceil($price*$count/10)/100;
    }

    /**
     * 余额变动记录
     * @param int $uid
     * @param int $money
     * @param string $remark
     * @param int $type
     * @return bool
     */
    public static function leftmoney($uid=0 , $money=0, $remark='' , $type=2){
        $uid = intval($uid);
        $money = floatval($money);
        if($uid<0){
            return false;
        }
        $money = $type == 2 ? -$money : $money;
        $member = D('member');
        $udata = $member->member(array('uid' =>$uid), 'leftmoney');
        if(empty($udata)){
            return false;
        }
        $diff_money = $udata['leftmoney'] + floatval($money);
        if(intval($diff_money) <0){
            return false;
        }
        try{
            DB::beginTransaction();
            $data['leftmoney'] = $diff_money;
            if(DB::update('member', $data, array('uid'=>$uid))){
                $add = array(
                    'uid'=>$uid,
                    'type'=>$type,
                    'balance'=>$diff_money,
                    'withdraw'=>0,
                    'cost'=>$money,
                    'create_time'=>TIMESTAMP,
                    'remark'=>$remark
                );
                if(!DB::insert('balance', $add)){
                    DB::rollBack();
                    return false;
                }
            }
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    /**
     * 添加付款说明
     */
    public static function addPayId($money =0){
        if( empty(\APP::$uid))  return false;
        $idata['money'] = $money;
        $idata['uid'] = \APP::$uid;
        $idata['username'] = \APP::$user['username'];
        $idata['addtime'] = TIMESTAMP;
        return DB::insert('payid', $idata);
    }
}