<?php
namespace App\Controller;
use Common\Model\PaymentsModel;
use WyPhp\Cache\Redis;
use WyPhp\DB;
use WyPhp\Filter;

class main extends baseController {
    public function actionIndex(){
        $banner = D('Banner');
        $banner_arr = $banner->getlist('img,url,pos', ['pos' =>['in',[1,2,3]]],'o desc',10);
        foreach ($banner_arr as $v){
            $v['img'] = picSize(str_replace('small_','',$v['img']) );
            $data['banner'][$v['pos']][] = $v;
        }
        $table = array(
            'menus' =>'mn',
            'left' =>'mn.typeid=ac.typeid',
            'archives' =>'ac',
        );
        $data['classlist'] = DB::fetch_all($table,'mn.typename,ac.description,mn.typeid',['mn.stype'=>1,'mn.ishide'=>1,'mn.pid'=>7]);
        //优秀学员
        $archivesModel = D('Archives');
        $arr = $archivesModel->getlist('arid,extend,thumb,typeid,description,title',['typeid'=>['in',[5,26]]],'weight desc,arid desc','');
        foreach ($arr as $k=> $v){
            if($v['typeid'] == 5){
                $v['thumb'] = picSize($v['thumb']);
                $v['extend'] = $v['extend'] ? unserialize($v['extend']) : [];
                $k<8 and $data['yxlist'][$k] = $v;
                $data['stulist'][$k] = $v;
            }else{
                $data['ys_data'][] = $v;
            }
        }

        $data['reply'] = DB::fetch_all('reply','addtime,contents',[],'id desc',7);

        $this->assign('data', $data);
        $this->render();
    }

    public function actionPostppre(){
        $data = Filter::$gp['data'];
        if(!$data['uname']){
            $this->error('请输入姓名');
        }
        if(!$data['phone']){
            $this->error('请输入电话号码');
        }
        if(!isMobile($data['phone'])){
            $this->error('请输入正确的手机号');
        }
        if(!$data['classes']){
            $this->error('请选择年级');
        }
        if(!$data['professional']){
            $this->error('请选择专业水平');
        }
        if(!$data['culture']){
            $this->error('请选择文化课');
        }
        if(DB::result_first('pretest','id',['phone' =>$data['phone']])){
            $this->error('您已成功领取，不能重复领取');
        }
        if(DB::insert('pretest',$data)){
            $this->success('领取成功');
        }
        $this->error('领取失败');
    }
    public function actionReply(){
        $data = Filter::$gp['data'];
        if(!$data['username']){
            $this->error('请输入姓名');
        }
        if(!$data['phone']){
            $this->error('请输入电话号码');
        }
        if(!isMobile($data['phone'])){
            $this->error('请输入正确的手机号');
        }
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $this->error('请输入正确邮箱');
        }
        if(!$data['contents']){
            $this->error('请输入内容');
        }
        $data['addtime'] = TIMESTAMP;
        if(DB::insert('reply',$data)){
            $this->success('提交成功');
        }
        $this->error('提交失败');
    }
    public function actionPostJoin(){
        $formhash = $_SERVER['HTTP_X_CSRF_TOKEN'];
        if($formhash != formhash()){
            $this->error('无效提交，刷新后再提交');
        }
        $this->outData['method'] = 'write';
        $this->outData['runFunctionJson'] = 'joinbackfun';
        $data = Filter::$gp['data'];
        $this->outData['data']['status'] = 0;
        if(!$data['name']){
            $this->outData['data']['msg'] = '请填写姓名';
            $this->printJson();
        }
        if(!isMobile( $data['phone'])){
            $this->outData['data']['msg'] = '请填写正确的电话';
            $this->printJson();
        }

        if(!$data['address']){
            $this->outData['data']['msg'] = '请填写详细地址';
            $this->printJson();
        }
        if(!$data['money']){
            $this->outData['data']['msg'] = '请选择资金范围';
            $this->printJson();
        }
        $data['addtime'] = TIMESTAMP;

        if(DB::insert('join',$data)){
            $status = 1;
        }
        $this->outData['data']['status'] = $status;
        $this->printJson();
    }
    public function actionMongo(){
        /*DB::$db_checks = [
            'db_tag'=>'mongo_'
        ];
        $data['list'] = DB::fetch_all('mydb','*',['age'=>['in',[3,4]],'name'=>'菜鸟教程2']);
        $data['list1'] = DB::fetch_all('mydb','*',['age'=>['in',[3,4]],'name'=>'菜鸟教程42']);
        print_r($data);*/
    }
    public function actionRabbitmqsend(){
        /*require_once FWPATH . '/plugins/vendor/autoload.php';
        $X = new Rabbitmq();
        $X->sendMessage('hello',date('Y-m-d H:i:s'));*/
        $redis = new Redis();
        $redis->rpush('hello', date('Y-m-d H:i:s'));
    }
    public function actionRabbitmqget(){
        $redis = new Redis();
        $s = $redis->lpop('hello');
        print_r($s);
    }
    public function actionAlipay(){
        $paymentsModel =  new PaymentsModel();
        $data = $paymentsModel->alipay(1,2,3,4);
        if($data == false){
            print_r($paymentsModel->getError());
        }
        print_r($data);
    }

}