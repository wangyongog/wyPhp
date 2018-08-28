<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26
 * Time: 11:05
 */

namespace App\Controller;
use Common\Model\TaskModel;
use WyPhp\DB;
use WyPhp\Filter;

class tasks extends baseController{
    private function _task_list($type='task', $fields='*'){
        $where['type'] = $type == 'task' ? array('in',['task','gaosu']) : $type;
        if(I('title')){
            $where['title'] = ['like',"'%".urlencode(I('title'))."%'"];
        }
        if(I('username')){
            $where['username'] = I('username');
        }
        if(I('url')){
            $url = I('url');
            $s_url = strpos($url,'__biz=') != false ? strstr(strstr($url,'sn='), '&',true) : trim(strstr($url,'s/'),'s/');
            /*if(strpos($url,'__biz=') != false){
                $s_url = strstr(strstr($url,'sn='), '&',true) ;
            }else{
                $s_url = trim(strstr($url,'s/'),'s/') ;
            }*/
            $where['url'] = ['like','"%'.$s_url.'%"'];
        }
        if(I('status')){
            $where['status'] = I('status') <0 ? I('status') : I('status')-1;
        }
        //$this->limit = 5;
        $taskModel = new TaskModel();
        $this->count = DB::count($taskModel->table, $where);
        $tasks = $taskModel->getList($where, $fields, $this->limit, $this->page);
        //$task_config = F('task');
        $task_config = F('SHOW_LIST')[$type];
        $task_return = [];
        if($tasks){
            foreach ($tasks as $k=> $task){
                /*$extra=json_decode($task['extra'],true);
                unset($task['extra']);
                if($extra){
                    $task=array_merge($task,$extra);
                }*/
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
    public function actionIndex(){
        $type = I('type');
        if(IS_AJAX){
            $hands = '';
            $task_config = F('SHOW_LIST')[$type];
            $data = $this->_task_list($type);
            $html_row = '';
            if($data){
                foreach ($data as $val){
                    if(!$val['status'] && !$val['isclose']){
                        $hands .= '<a href="javascript:;" _msg="确定执行此任务？" class="tipClose" _url="'.U('tasks/status',['tid'=>$val['tid'],'status'=>1,'token'=>creatToken($val['tid'])]).'">执行</a> | ';
                    }
                    if(in_array($val['status'],[0,1])){
                        $hands .= '<a href="javascript:;" _msg="确定关闭此任务？" class="tipClose" _url="'.U('tasks/status',['tid'=>$val['tid'],'status'=>-1,'token'=>creatToken($val['tid'])]).'">关闭</a> | ';
                    }
                    if($val['status'] == 1){
                        $hands .= '<a href="javascript:;" _msg="确定完成此任务？" class="tipClose" _url="'.U('tasks/status',['tid'=>$val['tid'],'status'=>2,'token'=>creatToken($val['tid'])]).'">完成</a>';
                    }
                    $html_row .= '<tr>';
                        foreach ($task_config as $k =>$v){
                            if(empty($v['hidden'])){
                                $html_row .= '<td>';
                                if(in_array($k,['remark'])){
                                    $html_row .= '<textarea placeholder="" _url="'.U('tasks/remark', array('tid'=>$val['tid'],'token'=>creatToken($val['tid']))).'" class="layui-textarea">'.$val[$k].'</textarea>';
                                }elseif (in_array($k,['kscount'])) {
                                    $html_row .= '<textarea placeholder="" _url="'.U('tasks/kaisnum', array('tid'=>$val['tid'],'token'=>creatToken($val['tid']))).'" class="layui-textarea">'.$val[$k].'</textarea>';
                                }elseif (in_array($k,['title'])){
                                    $html_row .= '<a href="'.$val['url'].'" target="_blank">'.$val[$k].'</a>';
                                } else{
                                    $html_row .= $val[$k];
                                }
                                $html_row .= '</td>';
                            }
                        }
                    $html_row .= '<td>'.rtrim($hands,' | ').'</td>';
                    $html_row .'</tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $task_config = F('task');
        $task_config = $task_config['SHOW_LIST'][$type];
        $this->assign('show_list', $task_config);
        $this->render();
    }
    public function actionStatus(){
        $tid = I('tid', 'int');
        $status = I('status', 'int');
        if($tid && creatToken($tid) == I('token')){
            $taskModel = D('Task');
            if($taskModel->chang_status($tid, $status)){
                if(in_array($status, [-1,2])){
                    $readsModel = D('Reads');
                    $readsModel->close($tid);
                    if($status == -1){
                        $stype = DB::fetch_first('task','`type`',['tid'=>$tid]);
                        TaskModel::mlog(['tid'=>$tid,'uid'=>$this->admin['uid'],'stype'=>$stype['type']]);
                    }

                }
                $this->success('操作成功！');
            }
            $this->error($taskModel->getError());
        }
    }
    public function actionRemark(){
        $tid = I('tid', 'int');
        $remark = I('remark');
        if(IS_AJAX){
            if($tid && creatToken($tid) == I('token')){
                 DB::update('task', array('remark' =>$remark), array('tid'=>$tid));
            }
        }
    }
    public function actionKaisnum(){
        $tid = I('tid', 'int');
        $num = I('remark');
        if(IS_AJAX){
            if($tid && creatToken($tid) == I('token')){
                DB::update('task', array('kscount' =>$num), array('tid'=>$tid));
            }
        }
    }
}