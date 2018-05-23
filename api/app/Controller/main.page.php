<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 14:38
 */
namespace App\Controller;

use WyPhp\DB;

class main extends baseController{
    public $st_no = [
        'task' =>1,
        'dianzan' =>2,
        'taocan' =>3,
        'fans' =>4
    ];
    public function actionIndex(){
        $phoneId = I('id','int');
        if(!$phoneId){
            die('请传入手机编号！');
        }
        file_put_contents(ROOT.'/data/get.txt',date('Y-m-d H:i:s').' '.$phoneId.NL,FILE_APPEND);
        //$arr = M('reads')->where(array('finish'=>0,'ispao'=>0))->order('isgaosu DESC,rsid ASC')->limit(15)->getField('tid,url,stype,rsid');
        $narr = [];
        $arr = DB::query('SELECT `tid`,`url`,`stype`,`rsid` FROM `nf_reads` WHERE `finish` = 0 AND `ispao` = 0 and rsid not in(SELECT rsid FROM nf_seno where phoneId="'.$phoneId.'") ORDER BY isgaosu DESC,rsid ASC LIMIT 20');
        if(empty($arr)){
            foreach ($arr as $k => $v){
                if($v['stype'] == 'gaosu'){
                    $v['stype'] = 'task';
                }
                if(empty($this->st_no[$v['stype']])) continue;
                $map[] = $v['tid'];
                $narr[] = array(
                    'tid' =>$v['tid'],
                    'url' =>html_entity_decode($v['url']),
                    'st' =>$this->st_no[$v['stype']],
                );
                $insert[] = array(
                    'tid' => $v['tid'],
                    'rsid' => $v['rsid'],
                    'phoneId' => $phoneId,
                    'oldid' => $phoneId,
                    'addtime' => TIMESTAMP
                );
            }
        }
        //!empty($insert) and DB::multi_insert('seno', $insert);

        unset($arr);
        $data['list'] = $narr;
        $data['count'] = count($data['list']);
        $this->printJson($data);
    }
    public function actionPpost(){
        $tidArr = I('tids');
        $phoneId = I('id', 'int') ;
        file_put_contents(ROOT.'/data/post.txt',date('Y-m-d H:i:s'). ' '. $phoneId.' | '.$tidArr.NL,FILE_APPEND);
        $tidArr = json_decode(html_entity_decode($tidArr), true);
        /*$tidArr = array(
            14466 =>1,
            14467 =>1,
            14468 =>0,
            14469 =>1
        );*/
        //print_r(json_decode(html_entity_decode('{&quot;4&quot;:2,&quot;7&quot;:2,&quot;1&quot;:2,&quot;2&quot;:2,&quot;3&quot;:0,&quot;5&quot;:2,&quot;6&quot;:2,&quot;8&quot;:2,&quot;9&quot;:2,&quot;10&quot;:2,&quot;11&quot;:2,&quot;12&quot;:2,&quot;13&quot;:2,&quot;14&quot;:2}'), true));exit;
        //print_r($tidArr);exit;
        if($tidArr && $phoneId){
            file_put_contents(ROOT.'/data/post.txt' ,date('Y-m-d H:i:s').' '.json_encode($tidArr) .NL,FILE_APPEND);
            $sdata = DB::fetch_all('reads', 'tid,count,dqreads', array('tid'=>array('in',array_keys($tidArr))));
            if($sdata){
                foreach ($sdata as $v){
                    $sdata[$v['tid']] = $v;
                }
            }
            //print_r($sdata);exit;
            foreach ($tidArr as $k=> $v){
                $data = [];
                $data['ispao'] = 0;
                $data['lastup'] = NOW_TIME;
                if($v>0 && is_numeric($k)){
                    $data['dqreads'] = ['exp','dqreads+'.$v];
                    if((($sdata[$k]['count'] - ($sdata[$k]['dqreads'] +$v)) <=1) && isset($sdata[$k]['count'])){
                        $data['finish'] = 1;
                    }
                }
                $v ==0 and $ntid[] = intval($k);
                DB::update('reads', $data, array('tid'=>intval($k)));
            }
            !empty($ntid) && $phoneId and  DB::update('seno' ,array('phoneId'=>'','uptime' =>TIMESTAMP), array('tid'=>array('in',$ntid),'phoneId' =>$phoneId));
            exit('ok');
        }else{
            file_put_contents(ROOT.'/data/post.txt',date('Y-m-d H:i:s'). ' no '.NL,FILE_APPEND);
            exit('no');
        }
    }
}