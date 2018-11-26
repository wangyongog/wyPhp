<?php
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Filter;

class setting extends baseController {
    public function actionIndex(){
        $task_config = F('task');
        $tasktype = array(
            0 => $task_config['TASK_TYPE'],
            1 => $task_config['TASK_TYPE1']
        ) ;
        if(IS_AJAX){
            if(check_formhash() === false){
                $this->error('无效操作！');
            }
            $stype = I('stype');
            $data['sitename'] = I('sitename');
            $data['taskshow'] = Filter::$gp['show_type'];
            $data['isadd'] = I('isadd');
            $data['agent'] = I('fee_for');
            $data['isreg'] = I('isreg') == 'on' ? 1 : 2;
            $data['notice'] = I('notice_msg','');
            $data['recharge'] = I('recharge_msg','');

            //print_r(Filter::$gp);exit;
            foreach (Filter::$gp['prices_list'] as $key => $value ) {
                if(in_array($key, array_keys($tasktype[$stype]))){
                    if (is_array ( $value )) {
                        foreach ( $value as $k => $v ) {
                            if (( float ) $v > 0) {
                                $data['price'][$key][$k] = round($v, 2 );
                            } else {
                                $this->error ( '价格填写错误,请检查' );
                            }
                        }
                    }
                }
            }
            //print_r($data);exit;
            foreach ($data as $k => $v) {
                DB::update('setting',array('value' =>$v ? serialize($v) : '' ),array('k'=>$k,'type'=>$stype)) ;
            }
            S('setting'.$stype ,serialize($data),3600*5);
            $this->success('提交成功！');
            die();
        }
        $set = D('aceAdmin/Setting');
        $data = $set->get_setting('', 'all');
        //print_r($data);exit;
        $this->assign('userGrades', $task_config['TASK_GRADE']);
        $this->assign('taskType', $task_config['TASK_TYPE']);
        $this->assign('taskType1', $task_config['TASK_TYPE1']);
        $this->assign('task_prices',$data[0]['price']);
        $this->assign('task_prices1',$data[1]['price']);
        $this->assign('data', $data);
        $this->render();
    }
}