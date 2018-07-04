<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 14:38
 */
namespace App\Controller;
use WyPhp\DB;
use WyPhp\Encrypt;
use WyPhp\Images\EasyPhpThumbnail\PHP5\easyphpthumbnail;
use WyPhp\Images\PicThumb;

class main extends baseController{
    public function actionIndex(){
        $data = DB::fetch_all('notice','*', ['map'=>0], 'id DESC', 30,$this->page);
        $this->assign('data',$data);
        $this->render();
    }
    public function actionReply(){
        if(IS_AJAX){
            $where['uid'] = $this->uid;
            $this->count = DB::count('feedback' ,$where);
            $data = DB::fetch_all('feedback','*', $where, 'id DESC', $this->limit, $this->page);
            $html_row = '';
            if($data){
                foreach ($data as $val){
                    $html_row .= '<tr>
                        <td>'.$val['notice'].'</td>
                        <td>'.$val['reply'].'</td>
                        <td>'.date('Y-m-d H:i', $val['create_time']) .'</td>
                      </tr>';
                }
            }
            $this->tbody_html = $html_row;
            $this->dynamicOutPrint();
        }
        $this->render();
    }
    public function actionPost(){
        if(IS_AJAX){
            if(check_formhash(I('formhash')) === false){
                $this->error('无效操作！');
            }
            if(!I('content')){
                $this->error('请输入反馈内容！');
            }
            $data['uid'] = $this->uid;
            $data['notice'] = I('content');
            $data['create_time'] = TIMESTAMP;
            if(DB::insert('feedback', $data)){
                $this->success('提交成功！');
            }
            $this->error('提交失败！');
        }
    }
    public function actionTest(){
        $s = new Encrypt\Openssl();
        $x = $s->pubEncrypt('ks$#234223sKSJK3');
        echo $x.'<br>';
        echo $s->privDecrypt($x);

        /*$b = $s->pubEncrypt('发生的woerKjks');
        echo $b.'<br>';
        echo $s->privDecrypt($b);*/
    }
    public function actionThumb(){
        $param = array(
            'type' => 'fit',
            'width' => 320,
            'height' => 320,
            'bgcolor' => '#FFF'
        );
        $source1 = ROOT.'/attaches/uploads/1704893933937459903.jpg';
        $dest1 = ROOT.'/attaches/uploads/'.md5('image').uniqid().'.jpg';
        $obj = new PicThumb();
        $obj->set_config($param);
        $flag = $obj->create_thumb($source1, $dest1);

        if($flag){
            echo '<img src="'.$dest1.'">';
        }else{
            echo 'create thumb fail';
        }
    }
    public function actionThumb1(){
        $thumb = new easyphpthumbnail;
        //$thumb -> Thumbheight = 200;
        //$thumb -> Thumbwidth = 200;
        $thumb -> Thumbsize = 80;
        $thumb ->Thumblocation = ROOT.'/attaches/uploads/';
        $thumb ->Thumbprefix = 'thumb_';
        $thumb ->Thumbfilename = md5('ssdf').uniqid().'.jpg';
        $thumb->Createthumb(ROOT.'/attaches/uploads/1704893933937459903.jpg','file');
    }
}