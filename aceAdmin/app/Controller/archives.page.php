<?php

namespace App\Controller;
use WyPhp\CF;
use WyPhp\DB;
use WyPhp\Filter;

class archives extends baseController{
    public function actionIndex(){
        $where = [];
        $typeid = G('typeid','int',0);
        if($typeid){
            $where['typeid'] = $typeid;
        }
        if(G('title')){
            $where['title'] = ['like','"%'.G('title').'%"'];
        }

        $this->count = DB::count('archives', $where);

        $data = DB::fetch_all('archives',['*'],$where, 'arid DESC',$this->limit,$this->page);
        $this->pageBar();
        $this->assign('typeMenus', CF('WEB_TYPEID'));
        $this->assign('data', $data);
        $this->render();
    }
    public function actionAdd(){
        $arid = G('arid','int');
        if(IS_POST){
            $data = Filter::$gp['data'];
            $flag = Filter::$gp['flag'];
            if($_FILES['files']){
                $info = upload(array($_FILES['files']) );
                if($info){
                    $data['thumb'] = $info['path'];
                }
            }

            if($_FILES['worksfile']){
                $works = [];
                $num = count($_FILES['worksfile']['name']);
                for ($i=0; $i<$num;$i++){
                    $arr[] = [
                        'name' =>$_FILES['worksfile']['name'][$i],
                        'type' =>$_FILES['worksfile']['type'][$i],
                        'tmp_name' =>$_FILES['worksfile']['tmp_name'][$i],
                        'error' =>$_FILES['worksfile']['error'][$i],
                        'size' =>$_FILES['worksfile']['size'][$i],
                    ];
                    $info = upload($arr);
                    if($info){
                        $works[] = $info['path'];
                    }
                }

            }
            $works_data = Filter::$gp['edata'];
            if (!empty($works_data['workslist'])){
                $arrworkslist = Filter::$gp['arrworkslist'];

                foreach ($works_data['workslist'] as $k=> $v){
                    $works_data['workslist'][$k] = [
                        'title' =>$v,
                        'img' =>isset($works[$k]) ? $works[$k] : (isset($arrworkslist[$k]) ? $arrworkslist[$k]: '')
                    ];
                }
            }
            $data['extend'] = $works_data ? serialize($works_data) : '';
            if(!$data['title']){
                $this->error('请填写标题');
            }
            $bdata['article_body'] = G('contents','','','htmlspecialchars');
            if(!$bdata['article_body']){
                $this->error('请填写文章内容');
            }
            $arcModel = D('aceAdmin/Archives');
            $data['flag'] = $flag ? implode(',', $flag) : '';

            $data['adduid'] = $this->admin['uid'];
            $data['hide'] = isset($data['hide']) ? 0 : 1;
            $data['puttime'] = $data['puttime'] ? strtotime($data['puttime']) : TIMESTAMP;

            if($arid){
                if($arcModel->edit($data, $bdata,['arid'=>$arid])){
                    $this->success('提交成功',U('archives/index'));
                }else{
                    $this->error('提交失败');
                }
            }else{
                $data['addtime'] = TIMESTAMP;
                if($arcModel->add($data, $bdata)){
                    $this->success('提交成功',U('archives/index'));
                }else{
                    $this->error('提交失败');
                }
            }
        }


        if($arid){
            $table = array(
                'archives' =>'ac',
                'left' =>'ac.arid=at.arid',
                'article' =>'at',
            );
            $data = DB::fetch_first($table,['ac.*','at.article_body'],['ac.arid'=>$arid]);
            $data['thumb'] = picSize($data['thumb']);
            $data['ext_data'] = $data['extend'] ? unserialize($data['extend']) : [];
            $this->assign('data', $data);
            $this->assign('arid', $arid);
        }


        $typeMenus = CF('WEB_TYPEID');
        $typeid = G('typeid','int');
        $this->assign('extend_list', getExtend($typeid, $data['ext_data']));
        $this->assign('typeid',$typeid);
        $this->assign('typeMenus',$typeMenus);
        $this->render();
    }

    public function actionDel(){
        $id = G('arid','int',0);
        $token = G('token');
        if(!$id){
            $this->error('无效操作！');
        }
        $archivesModel = D('aceAdmin/Archives');
        if($archivesModel->del(['arid'=>$id])){
            $this->outData['reload'] = 1;
            $this->success('操作成功！');
        }
        $this->error('删除失败！');
    }

}