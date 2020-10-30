<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/28
 * Time: 17:34
 */

namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;

class TaskModel extends Model{
    public $table = 'task';
    protected $_validate=array(
        //array('url','url','请输入正确的网址',self::MUST_VALIDATE),
        array('url','','请输入正确的网址', self::MUST_VALIDATE, 'unique'),
        array('title','require','请输入您的标题',self::MUST_VALIDATE),
        array('count','number','任务数量错误',self::MUST_VALIDATE),
        array('count','100,999999999','任务数量最少100',self::MUST_VALIDATE,'between'),
        //array('speed','number','请选择一个速度',self::MUST_VALIDATE),
        array('thumb','number','点赞不能超过千分之30',self::EXISTS_VALIDATE,),
        array('thumb','0,30','点赞不能超过千分之30',self::EXISTS_VALIDATE,'between'),
        array('type','task_type','请求错误',self::MUST_VALIDATE,'callback'),
        array('cost','is_float','计价错误,请重试',self::MUST_VALIDATE,'callback'),
    );
    protected $_auto=array(
        array('uid','get_uid' ,self::MODEL_INSERT,'callback'),
        array('username','get_user',self::MODEL_INSERT,'callback',0),
        array('pid','get_user',self::MODEL_INSERT,'callback',1),
        array('start_time',TIMESTAMP ,self::MODEL_INSERT),
    );
    public function getOne($condition=null, $fields='*'){
        return DB::fetch_first($this->table ,$fields, $condition);
    }
    public function get_uid(){
        return \APP::$uid;
    }
    public function get_user($s =0){
        return $s ? \APP::$user['pid'] : \APP::$user['username'];
    }
    public function getList($where, $fields='*', $limit, $page, $order='tid DESC'){
        return DB::fetch_all('task', $fields, $where,$order ,$limit, $page);
    }
    public function create($data){
        if($this->validate($data) == false) return false;
        return $this->autoOperation($data);
        //return DB::insert($this->table, $data);
    }
    public static function mlog($data){
        $idata['addtime'] = TIMESTAMP;
        $idata['stype'] = isset($data['stype']) ? $data['stype'] : '';
        $idata['money'] = isset($data['money']) ? $data['money'] : 0;
        $idata['tid'] = isset($data['tid']) ? $data['tid'] : 0;
        $idata['uid'] = isset($data['uid']) ? $data['uid'] : 0;
        DB::insert('mlog', $idata);
    }
    public static function get_curl_title($url){
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,30);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $output=curl_exec($ch);
        curl_close($ch);

        if(preg_match("/[\'\"]uft-8[\"\']/i", $output)){
            $charset='utf-8';
        }
        if(preg_match("/[\'\"]gbk[\"\']/i", $output)){
            $charset='gbk';
        }
        if(preg_match("/[\'\"]gB2312[\"\']/i", $output)){
            $charset='gb2312';
        }
        $data = array();
        if(preg_match("/<title[^>]*?>.+?<\/title>/i", $output,$match)){
            /* if($charset=='utf-8'){
                return strip_tags($match[0]);
            }else{
                return mb_convert_encoding(strip_tags($match[0]), 'UTF-8',$charset);
            } */
            $data['title'] = urlencode(strip_tags($match[0]));
            //return urlencode(strip_tags($match[0]));
        }
        if(preg_match('/<a[^>]*id="post-user"[^>]?>(.*?)<\/a>/si',$output,$match1)){
            $data['weixin_no'] = isset($match1[1]) ? $match1[1] : (empty($match1[1]) ? '' : strip_tags($match1[1]));
        }
        return $data;
    }

    /**
     * 更改任务状态
     *
     */
    public function chang_status($tid=0, $status=1){
        if(!$tid) return false;
        $task = DB::fetch_first($this->table,'status', array('tid'=>$tid));
        if(!$task){
            $this->error = '此任务不存在';
            return false;
        }
        if ($task['status'] == 2) {
            $this->error = '此条任务已完成，请刷新查看';
            return false;
        }
        if ($task['status'] == -1 && $status ==1) {
            $this->error = '此条任务已关闭，不能再次执行！';
            return false;
        }
        $data['status'] = intval($status);
        if($status == 2){
            $data['end_time'] = TIMESTAMP;
        }
        if (DB::update($this->table, $data, array('tid'=>$tid))) {
            return true;
        } else {
            $this->error = '更改失败，请重试';
            return false;
        }
    }
}