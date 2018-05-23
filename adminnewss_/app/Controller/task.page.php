<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/28
 * Time: 15:35
 */

namespace App\Controller;
use Common\Model\TaskModel;
use Common\Model\BalanceModel;
use WyPhp\DB;

class task extends baseController {
    private function _task_list($type='task', $fields='*'){
        $where['type'] = $type == 'task' ? array('in',['task','gaosu']) : $type;
        if(I('title')){
            $where['title'] = array('like',"'%".urlencode(I('title'))."%'");
        }
        if(I('status')){
            $where['status'] = I('status') <0 ? I('status') : I('status')-1;
        }
        $where['uid'] = $this->uid;
        //$this->limit= 1;
        $taskModel = new taskModel();
        $this->count = DB::count($taskModel->table,$where);
        $tasks = $taskModel->getList($where, $fields, $this->limit, $this->page);
        $task_config = F('SHOW_LIST')[$type];
        $task_return = [];
        if($tasks){
            foreach ($tasks as $k=> $task){
                if($task['url']){
                    $task['url'] = json_decode($task['url']);
                }
                if($task_config){
                    foreach ($task_config as $key=>$value){
                        if($value['func']){
                            $func=$value['func'];
                            $params=array();
                            if($value['param']){
                                foreach ($value['param'] as $param){
                                    $params[]=isset($task[$param])?$task[$param]:$param;
                                }
                            }
                            $task_return[$k][$key] = call_user_func_array($func, $params);
                            continue;
                        }
                        $task_return[$k][$key]=$task[$key];
                    }
                }
            }
        }
        return $task_return;
    }
    private function _check_url($url='',$type='task'){
        /*if(empty($url)) return true;
        if(strpos($url,'__biz=') != false){
            $s_url = strstr(strstr($url,'sn='), '&',true) ;
        }else{
            $s_url = trim(strstr($url,'s/'),'s/') ;
        }
        if($data = DB::fetch_first('task','*', array('type' =>$type,'url' =>array('like' ,'"%'.$s_url.'%"')))){
            return $data;
        } */
        return false;
    }
    public function actionTask(){
        $this->assign('data', $this->_task_list('task'));
        $this->pageBar();
        $task_config = F('task');
        $task_config = $task_config['SHOW_LIST']['task'];
        $this->assign('show_list', $task_config);
        $this->render();
    }
    public function actionTest(){
        $this->limit = 10;
        $this->assign('data',  $this->_task_list('task'));
        $task_config = F('task');
        $task_config = $task_config['SHOW_LIST']['task'];

        $this->pageBar();
        $this->assign('show_list', $task_config);
        $this->render();
    }
    public function actionDianzan(){
        $this->assign('data', $this->_task_list('dianzan'));
        $this->pageBar();

        $task_config = F('SHOW_LIST');
        $task_config = $task_config['dianzan'];
        $this->assign('show_list', $task_config);
        $this->render();
    }
    public function actionTaocan(){
        $this->assign('data', $this->_task_list('taocan'));
        $this->pageBar();

        $task_config = F('SHOW_LIST');
        $task_config = $task_config['taocan'];
        $this->assign('show_list', $task_config);
        $this->render();
    }
    public function actionFans(){
        $this->assign('data', $this->_task_list('fans'));
        $this->pageBar();
        $task_config = F('SHOW_LIST');
        $task_config = $task_config['fans'];
        $this->assign('show_list', $task_config);
        $this->render();
    }
    public function actionTaocanadd(){
        $zdmsg = array(
            'gzhh' =>'公众号会话',
            'hyzf' =>'好友转发',
            'pyq' =>'朋友圈',
            'lsxx' =>'历史消息',
            'wz' =>'未知',
        );
        $price = BalanceModel::get_member_price($this->uid, 'taocan', $this->user['grade'],1);
        if($price<=0 ){
            $this->error('系统出错请联系我们！',U('task/taocan'));
        }
        if(IS_POST) {
            $cost =0;
            $type = 'taocan';
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            if(!I ('url')){
                $this->error ('请输入阅读连接!');
            }
            if(I('count','int') <=0){
                $this->error ('请输入阅读数量!');
            }
            $create = array();
            $create['url'] = trim(I('url')) ;
            $create['count'] = intval(I('count','int'));
            $create['thumb'] = 0;
            $create['mosi'] = 1;
            if($create['count']<500){
                $this->error('任务数量最少500!');
            }
            $get_data = TaskModel::get_curl_title($create['url']);
            $create['title'] = $get_data['title'];
            $create['weixin_no'] = isset($get_data['weixin_no']) ? $get_data['weixin_no'] : '';
            if(!$create ['title']){
                $this->error ('链接错误！');
            }
            $create['from'] = 2;

            if(array_sum(Filter::$gp['data']) <500){
                $this->error('阅读来源总和必须大于500!');
            }
            $pbt = 0;
            foreach (Filter::$gp['data'] as $k=> $v){
                if(intval($v) >0){
                    //$pb = (($v / 100) * $create['count'] );
                    if($v <100){
                        $this->error($zdmsg[$k].'单量不能小于100');
                    }
                    //$pbt += $pb;
                }
            }
            $create['frommsg'] = serialize(Filter::$gp['data']);

            $create['cost'] = BalanceModel::get_task_cost($price, $create['count']);
            $create['type'] = $type;
            $return['tasks'][] = $create;
            $model = new TaskModel();
            $insert = $model->create( $create );
            if(!$insert){
                $this->error('无效提交');
            }
            $return['tasks'][] = $create;
            $model = new TaskModel();
            $insert = $model->create( $create );
            if(!$insert){
                $this->error('无效提交');
            }
            $cost = $insert['cost'];
            $taskModel = D('Task');
            $insert = $taskModel->create($create);
            if($insert === false){
                $this->error($taskModel->getError());
            }
            $insert['url'] = json_encode($insert['url']);
            if ($cost <= $this->user['leftmoney'] && $this->user['leftmoney']>0) {
                $remark = '【'. F('TASK_TYPE')[$type].'】'.'任务'.$insert['count'].'条,消费'.$cost.'元';
                $fal = BalanceModel::leftmoney($this->uid, $cost,$remark );
                if($fal== true){
                    $tid = DB::insert('task', $insert);
                }
            }else {
                $this->error( '余额不足' );
            }
            // 扣费
            if(!empty($tid)){
                $this->success('提交成功', U('task/taocan'));
            }else{
                $this->error ( '提交失败' );
            }
            die();
        }
        $this->assign('price', round($price/1000,5));
        $this->render();
    }
    public function actionFansadd(){
        $price = BalanceModel::get_member_price($this->uid, 'fans', $this->user['grade'],1);
        if($price<=0 ){
            $this->error('系统出错请联系我们！',U('task/fans'));
        }
        if(IS_POST) {
            $cost =0;
            $type = 'fans';
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            if(!I ('url')){
                $this->error ('请输入阅读连接!');
            }
            if(I('count','int') <=0){
                $this->error ('请输入阅读数量!');
            }
            $create = array();
            $create['url'] = I('url');
            $create['count'] = I('count','int');
            $create['thumb'] = 0;
            $create['title'] = I('url');
            $create['weixin_no'] = I('url');
            if(!$create ['title']){
                $this->error ('请填写公众号！');
            }
            if($create['count']<500){
                $this->error('加粉数量最少500!');
            }
            $create['from'] = 1;
            if($fdata = $this->_check_url(I ('url'), 'fans') !==false){
                $this->error('此链接不能重复下单!');
            }
            $create['cost'] = BalanceModel::get_task_cost($price, $create['count']);
            $create['type'] = $type;
            $create['map'] = 1;
            $return['tasks'][] = $create;
            $model = new TaskModel();
            $insert = $model->create( $create );
            if(!$insert){
                $this->error('无效提交');
            }

            $cost = $insert['cost'];
            $taskModel = D('Task');
            $insert = $taskModel->create($create);
            if($insert === false){
                $this->error($taskModel->getError());
            }
            $insert['url'] = json_encode($insert['url']);
            if ($cost <= $this->user['leftmoney'] && $this->user['leftmoney']>0) {
                $remark = '【'. F('TASK_TYPE')[$type].'】'.'任务'.$insert['count'].'条,消费'.$cost.'元';
                $fal = BalanceModel::leftmoney($this->uid, $cost,$remark );
                if($fal== true){
                    $tid = DB::insert('task', $insert);
                }
            }else {
                $this->error( '余额不足' );
            }
            // 扣费
            if(!empty($tid)){
                /*$create['tid'] = $tid;
                $readModel = D('Reads');
                $readModel->add($create);*/
                $this->success('提交成功', U('task/fans'));
            }else{
                $this->error ( '提交失败' );
            }
            die();
        }
        $this->assign('price', round($price/1000,5));
        $this->render();
    }
    public function actionTaskadd(){
        /*$zdmsg = array(
            'gzhh' =>'公众号会话',
            'hyzf' =>'好友转发',
            'pyq' =>'朋友圈',
            'lsxx' =>'历史消息',
            'wz' =>'未知',
        );  */
        $price = BalanceModel::get_member_price($this->uid, 'task', $this->user['grade'],1);
        $price1 = BalanceModel::get_member_price($this->uid, 'gaosu', $this->user['grade'],1);
        if(!$price || !$price1){
            $this->error('系统出错请联系我们！',U('task/task'));
        }
        if(IS_AJAX){
            $cost =0;
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            if(!I ('url')){
                $this->error ('请输入阅读连接!');
            }

            if(intval(I('count')) <=0){
                $this->error ('请输入阅读数量!');
            }
            if($fdata = $this->_check_url(I ('url')) !==false){
                $this->error ('此任务已存在，不能重复下单!');
            }
            $create = array();
            $create['url'] = trim(I('url')) ;
            $create['count'] = intval(I('count'));
            $create['thumb'] = intval(I('dz'));
            //$create['speed'] = 0;
            $create['mosi'] = intval(I('mosi',0));
            if(!$create['mosi']){
                $this->error('请选择模式');
            }
            if($create['count']<500){
                $this->error('任务数量最少500!');
            }
            $get_data = TaskModel::get_curl_title($create['url']);
            $create['title'] = $get_data['title'];
            $create['weixin_no'] = isset($get_data['weixin_no']) ? $get_data['weixin_no'] : '';
            if(!$create ['title']){
                $this->error ('链接错误！');
            }
            $create['from'] = 1;
            $create['map'] = 1;
            $price = $create['mosi'] == 2 ? $price1 : $price;
            $type = $create['mosi'] == 2 ? 'gaosu' : 'task';
            /*if(false == TaskModel::check_exsits($create['url'], $type)){
                $this->error('此连接已添加或在执行中，请稍后再试!');
            }*/
            $create['cost'] = BalanceModel::get_task_cost($price, $create['count']);
            if(floatval( $create['cost']<=0)){
                $this->error('消费金额不能小于0');
            }
            $create['type'] = $type;
            $create['contont'] = I('contont');
            $taskModel = D('Task');
            $insert = $taskModel->create($create);
            if($insert === false){
                $this->error($taskModel->getError());
            }
            $cost += $insert['cost'];
            $insert['url'] = json_encode($insert['url']);
            if ($cost <= $this->user['leftmoney'] && $this->user['leftmoney']>0) {
                $remark = '【'. F('TASK_TYPE')[$type].'】'.'任务'.$insert['count'].'条,消费'.$cost.'元';
                $fal = BalanceModel::leftmoney($this->uid, $cost,$remark );
                if($fal== true){
                    $tid = DB::insert('task', $insert);
                }
            }else {
                $this->error( '余额不足' );
            }
            // 扣费
            if($tid){
                /*$create['tid'] = $tid;
                $readModel = D('Reads');
                $readModel->add($create);*/
                $this->success('提交成功', U('task/task'));
            }else{
                $this->error ( '提交失败' );
            }
            die();
        }
        $this->assign('mosilist', F('MOSI'));
        $this->assign('price', round($price/1000,5));
        $this->assign('price1', round($price1/1000,5));
        $this->render();
    }
    public function actionTaskBatch(){
        $price = BalanceModel::get_member_price($this->uid, 'task', $this->user['grade'],1);
        $price1 = BalanceModel::get_member_price($this->uid, 'gaosu', $this->user['grade'],1);
        if(!$price || !$price1){
            $this->error('系统出错请联系我们！',U('task/task'));
        }
        if(IS_AJAX){
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            $cost = 0;
            $tasks = array_filter ( str_getcsv (I('tasks'), "\n" ) );
            $return = array ();
            $error_line = array ();
            $readModel = D('Reads');
            foreach ( $tasks as $key => $task ) {
                $cost = 0;
                $data = array_values(array_filter ( explode ( ' ', str_replace ( "\t", ' ', $task ) ) ));
                $create = array ();
                $create ['url'] = trim($data[0]) ;
                $create ['count'] = intval($data[1]);
                $create ['thumb'] = $data[2]? intval($data[2]) :0;
                $create ['contont'] = I('contont');
                $create['mosi'] = I('mosi','int');
                if($create ['url'] == ''){
                    continue;
                }
                if((int)$create['thumb']>30 || $create['thumb'] <0){
                    continue;
                }
                if($create['count'] <=0){
                    continue;
                }

                if($create ['count'] * 0.3 < $create['thumb']){
                    continue;
                }
                if($fdata = $this->_check_url(I ('url')) !==false){
                    continue;
                }
                $price = $create['mosi'] == 2 ? $price1 : $price;
                $type = $create['mosi'] == 2 ? 'gaosu' : 'task';
                $get_data = TaskModel::get_curl_title($create['url']);
                $create ['title']= $get_data['title'];
                if(!$create ['title']){
                    continue;
                }
                $create ['weixin_no']= isset($get_data['weixin_no']) ? $get_data['weixin_no'] : '';
                $create['cost'] = BalanceModel::get_task_cost($price, $create['count']);
                if(floatval($create['cost']<=0)){
                    continue;
                }
                $create['map'] = 1;
                $create['type']= $type;
                $taskModel = D('Task');
                $insert = $taskModel->create($create);
                if($insert === false){
                    $this->error($taskModel->getError());
                }

                $cost = $insert['cost'];
                $insert['url'] = json_encode($insert['url']);
                if ($cost <= $this->user['leftmoney'] && $this->user['leftmoney']>0) {
                    $remark = '【'. F('TASK_TYPE')[$type].'】'.'任务'.$insert['count'].'条,消费'.$cost['cost'].'元';
                    $fal = BalanceModel::leftmoney($this->uid,$cost,$remark );
                    if($fal== true){
                        $tid = DB::insert('task', $insert);
                        $tids[] = $tid;
                        $create['tid'] = $tid;
                        $readModel->add($create);
                    }
                }else {
                    $this->error( '余额不足' );
                }
            }
            if( !empty($tids) ){
                $this->success('提交成功',U('task/task'));
            }else{
                $this->error('提交失败,请检查连接是否有效！');
            }
            die();
        }
        $this->assign('mosilist', F('MOSI'));
        $this->assign('price', round($price/1000,5));
        $this->assign('price1', round($price1/1000,5));
        $this->render();
    }
    public function actionDianzanadd(){
        $price = BalanceModel::get_member_price($this->uid, 'dianzan', $this->user['grade'],1);
        if(!$price){
            $this->error('系统出错请联系我们！',U('task/dianzan'));
        }
        if(IS_AJAX){
            $cost =0;
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            if(!I ('url')){
                $this->error ('请输入阅读连接!');
            }
            if(intval(I('count')) <=0){
                $this->error ('请输入阅读数量!');
            }
            if($fdata = $this->_check_url(I ('url'), 'dianzan') !==false){
                $this->error ('此任务已存在，不能重复下单!');
            }
            $create = array();
            $create['url'] = trim(I('url')) ;
            $create['count'] = intval(I('count'));
            $create['thumb'] = 0;
            if($create['count']<100){
                $this->error ('任务数量最少100!');
            }
            $get_data = TaskModel::get_curl_title($create['url']);
            $create['title'] = $get_data['title'];
            $create['weixin_no'] = isset($get_data['weixin_no']) ? $get_data['weixin_no'] : '';
            if(!$create ['title']){
                $this->error ('链接错误！');
            }
            $create['map'] = 1;
            $create['from'] = 1;
            $create['cost'] = BalanceModel::get_task_cost($price, $create['count']);
            if(floatval( $create['cost']<=0)){
                $this->error('消费金额不能小于0');
            }
            $create['type'] = 'dianzan';
            $create['contont'] = I('contont','');
            //$return['tasks'][] = $create;
            $taskModel = D('Task');
            $insert = $taskModel->create($create);
            if($insert === false){
                $this->error($taskModel->getError());
            }
            $cost = $insert['cost'];
            $insert['url'] = json_encode($insert['url']);
            if ($cost <= $this->user['leftmoney'] && $this->user['leftmoney']>0) {
                $remark = '【'. F('TASK_TYPE')[$create['type']].'】'.'任务'.$insert['count'].'条,消费'.$cost.'元';
                $fal = BalanceModel::leftmoney($this->uid, $cost,$remark );
                if($fal== true){
                    $tid = DB::insert('task', $insert);
                }
            }else {
                $this->error('余额不足');
            }
            if($tid){
                /*$create['tid'] = $tid;
                $readModel = D('Reads');
                $readModel->add($create);*/
                $this->success('提交成功', U('task/dianzan'));
            }else{
                $this->error ( '提交失败' );
            }
            die();
        }
        $this->assign('price', round($price/1000,5));
        $this->render();
    }
    public function actionDianzanbatch(){
        $price = BalanceModel::get_member_price($this->uid, 'dianzan', $this->user['grade'],1);
        if(!$price){
            $this->error('系统出错请联系我们！',U('task/dianzan'));
        }
        if(IS_POST && IS_AJAX){
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            $cost = 0;
            $tasks = array_filter ( str_getcsv (I('tasks'), "\n" ) );
            $return = array ();
            $tid = array ();
            if(empty($tasks)){
                $this->error('批量提交格式有误！');
            }
            $readModel = D('Reads');
            foreach ($tasks as $key => $task ) {
                $data = array_values(array_filter(explode(' ', str_replace("\t", ' ', $task))));
                $create = array();
                $create['url'] = $data[0];
                $create['count'] = intval($data[1]) ;
                if(!$create['count'] || $create ['url'] == ''){
                    continue;
                }
                $get_data = TaskModel::get_curl_title($create['url']);
                $create['title']= $get_data['title'];
                if(!$create['title']){
                    continue;
                }
                $create['weixin_no']= isset($get_data['weixin_no']) ? $get_data['weixin_no'] : '';
                if($create['count']<100){
                    continue;
                }
                if($fdata = $this->_check_url(I ('url'), 'dianzan') !==false){
                    continue;
                }
                $create['from'] = 1;
                $create['thumb'] = 0;
                $create['map'] = 1;
                $create['cost'] = BalanceModel::get_task_cost($price, $create['count']);
                if(floatval($create['cost']<=0)){
                    continue;
                }
                $create['contont'] = I('contont');
                $create['type']= 'dianzan';
                $return['tasks'][] = $create;

                $taskModel = D('Task');
                $insert = $taskModel->create($create);
                if($insert === false){
                    $this->error($taskModel->getError());
                }
                $cost = $insert['cost'];
                $insert['url'] = json_encode($insert['url']);
                if ($cost <= $this->user['leftmoney'] && $this->user['leftmoney']>0) {
                    $remark = '【'. F('TASK_TYPE')[$create['type']].'】'.'任务'.$insert['count'].'条,消费'.$cost.'元';
                    $fal = BalanceModel::leftmoney($this->uid, $cost,$remark );
                    if($fal== true){
                        $tid = DB::insert('task', $insert);
                        $tids[] = $tid;
                        /*$create['tid'] = $tid;
                        $readModel->add($create); */
                    }
                }else {
                    $this->error('余额不足');
                }
            }
            if($tids){
                $this->success('提交成功',U('Task/dianzan'));
            }else{
                $this->error('提交失败');
            }
            die();
        }
        $this->assign('price', round($price/1000,5));
        $this->render();
    }
    public function actionDel(){
        $tid = I('tid', 'int');
        if($tid && creatToken($tid) == I('token')){
            $taskModel = D('Task');
            $data = $taskModel->getOne(array('tid'=>$tid, 'uid'=>$this->uid), 'type,status');
            if (empty($data)) {
                $this->error('此任务不存在');
            }
            if ($data['status'] == 2) {
                $this->error('此任务已完成，无法关闭');
            }
            if($data['status'] == -1){
                $this->error('此任务已关闭，无法关闭');
            }
            if(DB::update('task',array('isclose'=>1,'status'=>-1), array('tid'=>$tid, 'uid'=>$this->uid))) {
                $idata['stype'] = '';
                $idata['tid'] = $tid;
                $idata['uid'] = $this->uid;
                $readsModel = D('Reads');
                $readsModel->close($tid);
                TaskModel::mlog($idata);
                $this->success('操作成功！');
            }
        }
        $this->error('操作失败！');
    }
}