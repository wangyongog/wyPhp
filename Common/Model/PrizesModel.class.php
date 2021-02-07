<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Logs;
use WyPhp\Model;

class PrizesModel extends Model{
    public $table = 'prizes';
    protected $_validate=array();
    protected $_auto=array();
    //固定概率值，其实是100
    public $rand_v = 10000;
    const MAX_PRIZE = 8;
    public function no_prize(){
        return [
            'prize_name' =>'谢谢参与',
            'prizeid' =>0,
            'v' =>0,
            'img' =>CF('DOMAIN')['assets']. '/mall/images/no.png'
        ];
    }
    /**
     * 获取抽奖商品
     * @param $loid
     */
    public function getShowPrize($loid){
        $data['list'] = $this->getPrize($loid);
        if($data['list']){
            //随机打乱奖品
            //$data = SUtil::shuffle_assoc($data);
            $data['tips'] = $data['list'][0]['tips'];
            $data['name'] = $data['list'][0]['name'];
            $data['list'] = $this->SetPrizePosition($data['list']);
        }
        return $data;
    }
    /**
     * 抽奖商品
     * @param $loid
     * @return array
     */
    public function getPrize($loid){
        $data = [];
        if (!$loid) return $data;
        return DB::fetch_all([
            'prize_peak' =>'pp',
            'left' =>'p.issue_id=pp.id',
            'prize' =>'p',
        ],'p.*,pp.id,pp.name,pp.tips,pp.scene_id',['pp.id'=>$loid,'pp.isopen'=>1,'pp.stime'=>['lt',TIMESTAMP],'pp.etime'=>['gt',TIMESTAMP]]);
    }
    /**
     * 根据固定位置放置商品
     * @param $data
     */
    public function SetPrizePosition($prize){
        foreach ($prize as $k=> $v){
            $position_arr = explode(',', $v['position']);
            if($v['position'] && count($position_arr) >1){
                $p_arr[$k] = $position_arr;
                continue;
            }
            !$v['position'] and $v['position'] = 16;
            $data[$v['position']] = $v;
        }
        //拷贝相同产品不同位置
        if(!empty($p_arr)){
            foreach ($p_arr as $k=>$v){
                if($v){
                    foreach ($v as $val){
                        $prize[$k]['position'] = $val;
                        $data[$val] = $prize[$k];
                    }
                }
            }
        }

        //默认8个商品，小于了的用谢谢参与
        $total = count($data);
        if($total<self::MAX_PRIZE){
            //排序赵最大数
            $arr = array_keys($data);
            $last_pos = max($arr) ;
            $arr = my_sort($data,'position');
            $no_prize = $this->no_prize();

            if($last_pos && $last_pos <=self::MAX_PRIZE){
                for ($i=1; $i<=self::MAX_PRIZE; $i++){
                    $no_prize['position'] = $i;
                    $data[$i] = !isset($data[$i]) ? $no_prize : $data[$i];
                }
            }elseif ($last_pos && $last_pos >self::MAX_PRIZE){
                for ($i=1; $i<=$last_pos; $i++){
                    $no_prize['position'] = $i;
                    $data[$i] = !isset($data[$i]) ? $no_prize : $data[$i];
                }
            }
        }
        //重新排序
        $data = my_sort($data,'position');
        return $data;
    }
    /**
     * 排查奖品已被抽完的商品
     * @param $loid
     * @param $is_check false不排除
     * @return array
     */
    public function checkPrizeNum($loid, $is_check=false){
        $data = $this->getPrize($loid);
        if(!$data){
            $this->setError(101,'本期抽奖已结束');
            return false;
        }
        $data = $this->SetPrizePosition($data);
        if(!$is_check){
            return $data;
        }
        foreach ($data as $v){
            $prizeid[] = $v['prizeid'];
        }

        $cdata = DB::fetch_all('prizes_log','prizeid,sum(num) AS num', ['prizeid'=>['in',$prizeid],'loid' =>$loid],'','',1, 'prizeid');
        if($cdata){
            foreach ($cdata as $v){
                $arr[$v['prizeid']] = $v['num'];
            }
            //判断超过数量中奖概率设置0
            foreach ($data as $k=> $v){
                if(isset($arr[$v['prizeid']])){
                    $dif_num = bcsub($v['nums'], $arr[$v['prizeid']]);
                    if(bccomp($dif_num, 0) != 1){
                        $data[$k]['rand'] = 0;
                        continue;
                    }
                }
            }
        }
        return $data;
    }
    /**
     *
     * 获取抽奖商品
     * @param $loid
     * @param $is_check false不排除
     * @return array
     */
    public function getWinningGoods($loid, $uid,$is_check=false){
        if(!$loid){
            $this->setError(101,'抽奖期数不能为空');
            return false;
        }
        if(!$uid){
            $this->setError(101,'用户不能为空');
            return false;
        }

        $data = $this->checkPrizeNum($loid, $is_check);
        if($data === false){
            $this->setError(101,$this->getError());
            return false;
        }
        $total_v = 0;
        if($data){
            foreach ($data as $k=> $val) {
                $total_v += $val['rand'];
                if($val['prizeid']){
                    $scene_id = $val['scene_id'];
                    $loname = $val['name'];
                    $data[$k]['v'] = $val['rand'];
                }
            }
        }
        //根据场景 验证用户
        $user = $this->SceneCheckUid($scene_id, $uid);
        if($user === false){
            return false;
        }

        //计算参与概率
        $n_v = $this->rand_v >$total_v ? intval($this->rand_v -$total_v) : 0;
        //设置谢谢参与概率
        foreach ($data as $k=>$v){
            if(!$v['prizeid']){
                $data[$k]['scene_id'] = $scene_id;
                $data[$k]['name'] = $loname;
                $data[$k]['v'] = $n_v;
            }
        }
        //抽奖商品，获取抽奖结果
        if($data){
            foreach ($data as $val) {
                $arr_v[] = $val['v'];
            }
            $key = get_rand($arr_v);
        }
        //奖品数据
        $prize = isset($data[$key]) ?  $data[$key] : [];
        Logs::save( print_r($prize,true),'prize');
        //file_put_contents('./prize.txt', print_r($prize,true), FILE_APPEND);
        $prize['key'] = $key;
        //存在奖品，发奖
        if($prize['prizeid']){
            //加余额特殊处理，先入记录再发奖
            if($prize['type'] == 'user_money'){
                $plog_id = $this->addPlog($prize, $user,$loid);
                if($plog_id){
                    $idata = $this->SendTypePrizes($prize, $user ,$plog_id);
                }
                if($idata === false){
                    $this->setError(101,'系统错误请联系我们');
                }
                return $prize;
            }
            $idata = $this->SendTypePrizes($prize, $user);
            if($idata === false){
                return false;
            }
        }
        $idata = $idata ? array_merge($prize, $idata) : $prize;
        //插入记录
        if(!$this->addPlog($idata, $user, $loid)){
            return false;
        }
        return $prize;
    }
    /**
     * 中奖记录
     * @param $data 奖品
     * @param $user 用户人
     */
    public function addPlog($data, $user,  $loid=0){
        $prizeslogModel = new Model_cl_prizeslog();
        $prizeslogModel->_db->beginTransaction('cl');
        try {
            //记录抽奖
            $data['loid'] = $loid;
            $data['uid'] = $user['uid'];
            $data['money'] = isset($data['value']) ? $data['value'] : 0;
            $data['type'] = isset($data['type']) ? $data['type'] : 'thanks';
            $data['prizeid'] = isset($data['prizeid']) ? $data['prizeid'] : 0;
            $data['loname'] = isset($data['name']) ? $data['name'] : '';
            $data['num'] = 1;
            $data['phone'] = isset($user['phone']) && SValidate::IsMobile($user['phone']) ? $user['phone'] : '';
            $data['username'] = isset($user['username']) ? $user['username'] : '';
            $plog_id = $prizeslogModel->initData($data);
            $prizeslogModel->_db->commit('cl');
            return $plog_id;
        } catch (Exception $e) {
            $prizeslogModel->_db->rollBack('cl');
            $this->setError($e->getCode(), $e->getMessage());
            return false;
        }
    }
    /**
     * 根据不同奖品类型，发奖
     * @param $prize
     * @param $user
     */
    public function SendTypePrizes($prize, $user, $plog_id=0){
        $type = empty($prize['type']) ? '' : $prize['type'];
        if(!$type) return false;
        switch ($type){
            case 'money'://红包
                $hbinfoModel = new Model_cl_hbinfo();
                $hbinfoModel->_db->beginTransaction('cl');
                try {
                    $money = floatval($prize['value']) ;
                    $redpack = [
                        'mch_billno'   => isset($user['mch_billno']) ? $user['mch_billno'] : 'RPVIP' . SUtil::createOrderSn(),
                        'open_id'      => $user['wx_openid'],
                        'wishing'      => isset($user['wishing']) ?$user['wishing']: '会员',
                        'act_name'     => isset($user['act_name']) ?$user['act_name']: '会员',
                        'remark'       => isset($user['remark']) ?$user['remark']: '会员',
                        'total_amount' => bcmul($money, 100),
                        'send_name' =>isset($user['wishing']) ?$user['wishing']: '会员'
                    ];
                    $hbinfo_idata = array_merge($redpack, [
                        'tid'   => 0,
                        'ttype' => $user['ttype'],
                        'uid' => $user['uid']
                    ]);
                    $hbinfo_id = $hbinfoModel->initData($hbinfo_idata);
                    if (!$hbinfo_id) {
                        throw new Exception('插入红包记录失败！');
                    }
                    $lotteryModel = new Service_nf_lottery();
                    if(!$lotteryModel->sendRedpack($redpack, $hbinfo_id)){
                        throw new Exception('红包发送失败！');
                    }
                    $hbinfoModel->_db->commit('cl');
                    $res['tid'] = $hbinfo_id;
                }catch (Exception $e){
                    $hbinfoModel->_db->rollBack('cl');
                    $this->setError($e->getCode(), $e->getMessage());
                    return false;
                }
                break;
            case 'goods'://商品
                break;
            case 'point'://积分
                $point = intval($prize['point']) ;
                $res['tid'] = $point;
                break;
            case 'coupon_hb'://优惠券
                break;
            case 'coupon_goods'://实物券
                break;
            case 'free'://免最近一单
                break;
            case 'user_money'://杭菜加余额
                $money = floatval($prize['value']) ;
                $chargeModel = new Service_fi_charge();
                if(!$chargeModel->lotteryWin($user['uid'], $money, $plog_id)){
                    $this->setError(101, $chargeModel->getError());
                    return false;
                }
                break;
        }
        return $res;
    }
    /**
     * 根据场景，验证uid
     * @param $scene_id
     */
    public function SceneCheckUid($scene_id, $uid){
        $user = [];
        switch ($scene_id){
            case 0://会员
                $userModel = new Model_nf_uservip();
                $membermtModel = new Model_cm_membermt();
                $user = $userModel->getOne(['uid' => $uid], 'uid,nickname,poi_member_id,wx_openid');
                if (!$user) {
                    $this->setError(101, '不存在该用户！');
                    return false;
                }
                $member = $membermtModel->getOne(['poi_member_id' =>$user['poi_member_id']],'username,mobile,print_flag');
                if (!$member) {
                    $this->setError(101, '不存在该用户！');
                    return false;
                }
                if ($member['print_flag'] != '二钻' && $member['print_flag'] != '一钻') {
                    $this->setError(101, '限二钻、一钻会员参与！');
                    return false;
                }
                $user['ttype'] = 1;
                $user['username'] = $member['nickname'];
                $user['phone'] = $member['mobile'];
                $user['mch_billno'] = 'RPVIP' . SUtil::createOrderSn();
                break;
            case 1://骑手
                $user['ttype'] = 2;
                break;
            case 2://菜老包小程序
                break;
            case 3://杭菜科技小程序
                $userModel = new Model_nf_user();
                $user = $userModel->getOne(['uid' => $uid], 'uid,wx_openid,username');
                if (!$user) {
                    $this->setError(101, '不存在该用户！');
                    return false;
                }
                $businessModel = new Model_nf_business();
                $user['phone'] = $user['username'];
                unset($user['username']);
                $user['username'] = $businessModel->getOneVal(['uid'=>$uid],'business_name');
                $user['ttype'] = 9;
                $user['wishing'] = '抽奖';
                $user['act_name'] = '抽奖';
                $user['remark'] = '抽奖';
                $user['mch_billno'] = 'HCX'.SUtil::createOrderSn();
                break;
        }
        return $user;
    }
}