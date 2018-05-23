<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 14:38
 */
namespace App\Controller;
use WyPhp\Controller;
use WyPhp;

class main extends Controller{
    public function _initialize()
    {
        // TODO: Implement _initialize() method.
    }
    /*public function __construct($islogin =false){
        parent::__construct($islogin);
    }*/
    public function actionIndex(){
       // print_r($this->get('s'));
        //$this->set_cache();
        $this->assign('name','www');
        $this->assign('sex','女');
        $data = [
            '我',
            '他',
            '你'
        ];
        Cookie('kkkkkk','gggggg');
        echo Cookie('kkkkkk');
        print_r($_COOKIE);
        $this->assign('arr', $data);
        $this->render();
    }
    public function actionTrace(){
        $Trace = new WyPhp\Trace();
        print_r($Trace->showTrace());
    }
    public function actionSession(){
        NEW \WyPhp\Session();
        session('a','莱克斯顿浪费');
        session('ab','额外任务而sdfsttt');
        session('ddddd','sfadfsddd');
        print_r($_SESSION);
        exit;
    }
    public function actionCache(){
        $link = WyPhp\Cache::connect();
        //$link->set('name','44444',3600);
        echo $link->TTL('aaa6666');
        //$link->set('444333',['aaa'=>1111,'bbb'=>222],3600);
        //print_r($link->get('444333')) ;
    }
    public function actionSelect(){
        $table = array(
            'member' =>'m',
            'left' =>'m.uid=md.uid',
            'member_data' =>'md',
            'left1' =>'m.uid=a.uid',
            'attachments' =>'a'
        );
        $condition['m.uid'] = array('in',[190,191,156]);
        $x = WyPhp\DB::fetch_all($table, ['m.username AS U','m.realname','m.password','md.yqcode','m.uid'], $condition);
        print_r($x);
    }
    public function actionOne(){
        $table = array(
            'member' =>'m',
            'left' =>'m.uid=md.uid',
            'member_data' =>'md',
            'left1' =>'m.uid=a.uid',
            'attachments' =>'a'
        );
        $condition['m.uid'] = array('in',[190,191,156]);
        $x = WyPhp\DB::fetch_first($table, ['m.username AS U','m.realname','m.password','md.yqcode','m.uid'], $condition,'  m.uid DESC');
        print_r($x);
    }
    public function actionOneval(){
        $table = array(
            'member' =>'m',
            'left' =>'m.uid=md.uid',
            'member_data' =>'md',
            'left1' =>'m.uid=a.uid',
            'attachments' =>'a'
        );
        $condition['m.uid'] = array('in',[190,191,156]);
        $x = WyPhp\DB::result_first($table, 'username', $condition,'  m.uid DESC');
        print_r($x);
        //print_r(WyPhp\DB::);exit;
    }
    public function actionAdd(){
        $table = array(
            'member' =>'m',
            'left' =>'m.uid=md.uid',
            'member_data' =>'md',
            'left1' =>'m.uid=a.uid',
            'attachments' =>'a'
        );
        $condition['m.uid'] = array('in',[190,191,156]);
        $x = WyPhp\DB::result_first($table, 'username', $condition,'  m.uid DESC');
        print_r($x);exit;
        unset($data);
        unset($condition);


        $data['username'] = 'uuuuuu';
        $data['realname'] = 'bbbbb';
        $data['password'] = 'xxxxxx';
        $data['hash'] = '55555';
        $data['addtime'] = TIMESTAMP;
        //$condition['uid'] = 193;
        $condition['uid'] = array('eq',191);
        try{
            WyPhp\DB::beginTransaction();
            $x = WyPhp\DB::update('member',$data,$condition);
            WyPhp\DB::commit();
        }catch(\Exception $e){
            WyPhp\DB::rollBack();
        }



        unset($data);
       /* $data = array(
            ['username'=>'111','realname'=>'死灵法师了','password'=>'xxxxxx','hash'=>WyPhp\Sutil::random(),'addtime'=>TIMESTAMP],
            ['username'=>'2222','realname'=>'22是的发送到22','password'=>'rrr','hash'=>WyPhp\Sutil::random(),'addtime'=>TIMESTAMP],
            ['username'=>'3333','realname'=>'ddsfsf','password'=>'xxxxxx','hash'=>WyPhp\Sutil::random(),'addtime'=>TIMESTAMP],
            ['username'=>'4444','realname'=>'东三省的方式','password'=>'xxxxxx','hash'=>WyPhp\Sutil::random(),'addtime'=>TIMESTAMP]
        );
        //$x = WyPhp\DB::insert('member',$data);
        try{
            WyPhp\DB::beginTransaction();
            $x = WyPhp\DB::multi_insert('member',$data);
            WyPhp\DB::commit();
        }catch(\Exception $e){
            WyPhp\DB::rollBack();
        }

        unset($data);*/

        $data['ltype'] = 'sql';
        $data['url'] = $_SERVER['REQUEST_URI'];
        $data['addtime'] = TIMESTAMP;
        $data['msg'] = 'xxxxxx';
        $data['error'] = '222222222222';
        try{
            WyPhp\DB::beginTransaction(['prefix' =>'log_']);
            WyPhp\DB::insert('error', $data, false,['prefix' =>'log_']);
            WyPhp\DB::commit(['prefix' =>'log_']);
        }catch(\Exception $e){
            WyPhp\DB::rollBack(['prefix' =>'log_']);
        }


        $Trace = new WyPhp\Trace();
        print_r($Trace->showTrace());
    }
    public function actionEdit(){
        $options[''] = '';
        $data['username'] = 'aaaa111';
        $data['realname'] = 'bbbbb';
        $data['password'] = 'xxxxxx';
        $data['leftmoney'] = array('exp','leftmoney+1');
        $data['addtime'] = TIMESTAMP;
        //$condition['uid'] = 193;
        $condition['uid'] = array('eq',211);
        //$condition['hash'] = '123455';
        $x = WyPhp\DB::update('member',$data,$condition);
        print_r(WyPhp\DB::getsql());
    }
    public function actionDel(){
        $options[''] = '';
        $data['username'] = 'aaaa111';
        $data['realname'] = 'bbbbb';
        $data['password'] = 'xxxxxx';
        $data['hash'] = '55555';
        $data['addtime'] = TIMESTAMP;
        $condition['uid'] = array('in',[198,196,156]);
        $condition['hash'] = array('eq','12345','operate'=>'or');
        ///$condition['hash'] = '12345';
        $condition['DDD'] = array('eq','12345');
        //$condition['xx'] = array('like' =>'%12345%');
        $x = WyPhp\DB::delete('member',$condition);
        print_r($x);
    }
}