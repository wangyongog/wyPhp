<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 10:30
 */

namespace App\Controller;
use Common\Model\BalanceModel;
use WyPhp\DB;

class money extends baseController{
    public function actionIndex(){
        if(IS_AJAX){
            if(G('status')){
                $where['status'] = I('status');
            }
            if(G('username')){
                $where['username'] = I('username');
            }
            $this->count = DB::count('recharge', $where);
            $data = DB::fetch_all('recharge','*',$where, 'id DESC',$this->limit,$this->page);
            $html_row = '';
            if($data){
                $managerModel = D('aceAdmin/Manager');
                foreach ($data as $val){
                    $adminArr = $managerModel->getAdminUser($val['douid']);
                    $hands = '';
                    if($val['status'] == 1){
                        $hands = '<a href="javascript:;" _msg="确定通过？" class="tipClose" _url="'.U('money/chang',['id'=>$val['id'],'status'=>2,'token'=>creatToken($val['id'])]).'">通过</a> | <a href="javascript:;" _msg="确定驳回？" class="tipClose" _url="'.U('money/chang',['id'=>$val['id'],'status'=>3,'token'=>creatToken($val['id'])]).'">驳回</a>';
                    }
                    $html_row .= '<tr>
                        <td><label class="pos-rel"><input type="checkbox" class="ace ids" name="ids[]" value="'.$val['id'].'" ></label><span class="lbl"></span></td>
                        <td>'.$val['username'].'</td>
                        <td>'.$val['cost'].'</td>
                        <td>'.$val['alipay_number'] .'</td>
                        <td>'. date('Y-m-d H:i:s', $val['create_time']) .'</td>
                        <td>'.($val['status'] ==1 ? '未处理' : ($val['status'] ==2 ? '通过' : '未通过')) .'</td>
                        <td>'.$adminArr['user'].'</td>
                        <td>'.$hands.'</td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->assign('status', 1);
        $this->render();
    }
    public function actionChang(){
        $id = I('id','int');
        if(!$id || I('token') != creatToken($id)){
            $this->error('无效操作！');
        }
        $status = I('status', 'int');
        if(!in_array($status,[2,3])){
            $this->error('无效操作！');
        }
        $arr = DB::fetch_first('recharge', 'id,status,uid,cost ', array('id'=>$id));
        if($arr['status'] !=1){
            $this->error('此任务已被处理！');
        }
        if(DB::update('recharge',array('status' =>$status,'dotime'=>TIMESTAMP,'douid'=>$this->admin['uid']), array('id' =>$id))){
            if($status == 2){
                $balance = D('Balance');
                $balance->leftmoney($arr['uid'], $arr['cost'],'充值' ,1);
            }
            $this->success('操作成功！');
        }
        $this->error('操作失败！');
    }
    public function actionDetailed(){
        $balanceModel = D('Balance');
        $stype = $balanceModel->stype;
        if(IS_AJAX){
            if(I('stype')){
                $where['type'] = I('stype');
            }
            $memberModel = D('Member');
            if(I('username')){
                $where['uid'] = DB::result_first($memberModel->table,'uid', array('username'=>trim(I('username'))));
            }
            if(I('startime') && I('endtime')){
                $where['create_time'] = array('between',[strtotime(I('startime')), strtotime(I('endtime').' 23:59:59')]);
            }
            $this->count = DB::count('balance', $where);
            $data = DB::fetch_all('balance','*',$where, 'id DESC',$this->limit,$this->page);
            $html_row = '';

            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td class="center"><label class="pos-rel"><input id="ids" name="ids[]" value="'.$val['id'].'" type="checkbox" class="ace ids"><span class="lbl"></span></label></td>
                        <td>'.$memberModel->getUsername($val['uid']).'</td>
                        <td>'.$val['balance'].'</td>
                        <td>'.$stype[$val['type']]  .'</td>
                        <td>'. $val['cost'].'</td>
                        <td>'.$val['remark'] .'</td>
                        <td>'.date('Y-m-d H:i:s', $val['create_time']) .'</td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->assign('stype', $stype);
        $this->render();
    }
    public function actionTuik(){
        $isstatus = [
            1 =>'未处理',
            2 =>'已处理'
        ];

        if(IS_AJAX){
            if(I('status')){
                $where['isstatus'] = I('status');
            }
            if(I('username')){
                //$where['username'] = I('username');
            }
            $this->count = DB::count('mlog', $where);
            $data = DB::fetch_all('mlog','*',$where, 'id DESC',$this->limit,$this->page);
            $html_row = '';
            if($data){
                $managerModel = D('aceAdmin/Manager');
                $member = D('Member');
                $task_type = F('TASK_TYPE');
                foreach ($data as $val){
                    $adminArr = $managerModel->getAdminUser($val['douid']);
                    $hands = '';
                    if($val['isstatus'] == 1){
                        $hands = '<a href="javascript:;" _wh="700,430" class="edit" _title="退款" _url="'.U('money/postTuik', array('id'=>$val['id'],'tid'=>$val['tid'])).'">退款</a>';
                    }
                    $html_row .= '<tr>
                        <td>'.$member->getUsername($val['uid']).'</td>
                        <td>'.$val['tid'].'</td>
                        <td>'.$task_type[$val['stype']].'</td>
                        <td>'.date('Y-m-d H:i:s', $val['addtime']) .'</td>
                        <td>'. $isstatus[$val['isstatus']] .'</td>
                        <td>'.$adminArr['user'].'</td>
                        <td>'.$hands.'</td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->assign('status', 1);
        $this->render();
    }
    public function actionPostTuik(){
        $id = I('id','int',0);
        $tid = I('tid','int',0);
        if(IS_AJAX && $id && $tid){
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            if(I('token') != creatToken($id)){
                $this->error('无效操作！');
            }
            $sdata = DB::fetch_first('task', '*', array('tid'=>$tid));
            $money = I('money', 'float');
            if($money >0){
                $remark = '取消任务，退回'.$money.'元';
                $fal = BalanceModel::leftmoney($sdata['uid'], $money,$remark ,3);
                if($fal !=false){
                    DB::update('task',array('tmoney' =>$money),array('tid'=>$tid));
                }
            }
            $data['isstatus'] = 2;
            $data['douid'] = $this->admin['uid'];
            I('content') and $data['content'] = I('content');
            if(DB::update('mlog', $data, array('id'=>$id))){
                $this->success('操作成功！');
            }
            $this->error('操作失败！');
        }
        $this->assign('id', $id);
        $this->assign('tid', $tid);
        $this->render();
    }
    public function actionPayerroy(){
        if(IS_AJAX){
            if(I('status')){
                $where['pe.status'] = I('status') - 1;
            }
            $table = array(
                'payerroy' =>'pe',
                'left' =>'pe.pid=p.pid',
                'payid' =>'p'
            );
            $this->count = DB::count($table, $where);
            //echo  DB::getsql();exit;
            $data = DB::fetch_all($table,'pe.*,p.uid',$where, 'pe.epid DESC',$this->limit,$this->page);
            $html_row = '';
            if($data){
                $member = D('Member');
                foreach ($data as $val){
                    $hands = '';
                    if(!$val['status']){
                        $hands = '<a href="javascript:;" class="del" _title="确定已处理?" _url="'.U('money/postcl', array('epid'=>$val['epid'],'token'=>creatToken($val['epid']))).'">已处理</a>';
                    }
                    $html_row .= '<tr>
                        <td>'.$member->getUsername($val['uid']).'</td>
                        <td>'.$val['epayid'].'</td>
                        <td>'.$val['money'].'</td>
                        <td>'.date('Y-m-d H:i:s', $val['addtime']) .'</td>
                        <td>'.$hands.'</td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->assign('status', I('status','int',1));
        $this->render();
    }
    public function actionPostcl(){
        $id = I('epid','int',0);
        $token = I('token');
        if(!$id || $token !=creatToken($id)){
            $this->error('无效操作！');
        }
        if(DB::update('payerroy',['status'=>1],array('epid'=>$id))){
            $data['info'] = '操作成功！';
            $data['status'] = 1;
            $data['reload'] = 1;
            $this->printJson($data);
        }
        $this->error('删除失败！');
    }
    public function actionRecharge(){
        if(IS_AJAX){
            $where = [];
            if(I('username')){
                $where['username'] = I('username');
            }
            if(I('start') && I('end')){
                $where['create_time'] = ['between',[strtotime(I('start')),strtotime(I('end').' 23:59:59')]];
            }
            if(I('status')){
                $where['status'] = I('status');
            }
            $this->count = DB::count('recharge', $where);
            $data = DB::fetch_all('recharge','*',$where, 'uid DESC',$this->limit,$this->page);
            $html_row = '';
            if($data){
                foreach ($data as $val){
                    $Manager = D('aceAdmin/Manager');
                    $adminArr = $Manager->getAdminUser($val['douid']);
                    $hands = '';
                    $status_str = '审核中';
                    if($val['status'] >1){
                        $status_str = $val['status'] == 2 ? '驳回' : '通过';
                    }
                    if($val['status'] ==1){
                        $hands = '<a href="javascript:;" class="tipClose" _msg="确定通过" _url="'.U('money/changAlipay',['status'=>3,'id'=>$val['id'],'token'=>creatToken($val['id'])]).'">通过</a> | <a href="javascript:;" class="tipClose" _msg="确定驳回" _url="'.U('money/changAlipay',['status'=>2,'id'=>$val['id'],'token'=>creatToken($val['id'])]).'">驳回</a>';
                    }
                    $html_row .= '<tr>
                        <td><input type="checkbox" class="ids" name="ids[]" value="'.$val['id'].'" ></td>
                        <td>'.$val['username'].'</td>
                        <td>'.$val['alipay_number'].'</td>
                        <td>'.$val['cost'].'</td>
                        <td>'.date('Y-m-d H:i:s', $val['create_time']) .'</td>
                        <td>'.$status_str.'</td>
                        <td>'. $adminArr['user'].'</td>
                        
                        <td>'.$hands.'</td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionChangAlipay(){
        $id = I('id','int');
        $status = I('status');
        if(!$id){
            $this->error('无效ID');
        }
        if(creatToken($id) != I('token')){
            $this->error('无效操作');
        }

        if(!in_array($status, [2,3])){
            $this->error('无效');
        }
        $rdata = DB::fetch_first('recharge','status,uid,cost',['id'=>$id]);
        if($rdata['status'] !=1){
            $this->error('此信息已被操作！');
        }
        $data['status'] = $status;
        $data['douid'] = $this->admin['uid'];
        $data['dotime'] = TIMESTAMP;
        if(DB::update('recharge',$data,['id'=>$id])){
            if($status == 3){
                $Balance = D('Balance');
                $Balance->leftmoney($rdata['uid'],$rdata['cost'],'充值',1);
            }
            $this->success('操作成功！');
        }
        $this->error('操作失败！');
    }
}