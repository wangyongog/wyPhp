<?php
namespace Admin\Model;
use WyPhp\DB;
use WyPhp\Model;

class SidebarModel extends Model {
    private $_tabal = 'auth_rule';

    public function sidebarList($items=array(), $id = 'id', $pid = 'pid', $son = 'children'){
        $data = [];
        $where['status'] = 1;
        $items = DB::fetch_all($this->_tabal ,'id,pid,title,url,icon,o,status',$where ,'o ASC');
        $data = $this->getTree($items);
        S('sidebarlist' ,$data);
        return $data;
    }
    function getTree($array){
        $items = $tree = [];
        foreach($array as $value){
            $value['url'] = strtolower($value['url']);
            $items[$value['id']] = $value;
        }
        foreach($items as $key => $value){
            if(isset($items[$value['pid']])){
                $items[$value['pid']]['children'][] = &$items[$key];
                $items[$value['pid']]['acts'][] = $value['url'];
            }else{
                $tree[] = &$items[$key];
                $value['url'] && !$value['pid'] and $items[$key]['acts'][] = $value['url'];
            }
        }
        return $tree;
    }

    /**
     * 获取栏目层级关系
     * @return array
     */
    public function getHeadTitle(){
        $arr = S('breadcrumbs');
        $data = $arrlist = [];
        if(empty($arr)){
            $arr = DB::fetch_all($this->_tabal ,'id,pid,title,url',['status' =>1] ,'o ASC');
            S('breadcrumbs', $arr);
        }
        list($act, $par) = explode('?', $_SERVER['REQUEST_URI']);
        foreach($arr as $value){
            if(rtrim($act, F('URL_HTML_FIX')) == strtolower($value['url'])){
                $data[] = [
                    'name' =>$value['title'],
                    'url' =>$value['url']
                ] ;
                $pid = $value['pid'];
            }
            $items[$value['id']] = $value;
        }
        if($pid){
            $arrlist = $this->cateSort($items, $pid);
        }
        $data = array_merge($data, $arrlist);
        krsort($data);
        return $data;
    }
    public function cateSort($data, $pid=0, $level=0) {
        static $arr=[];
        if(isset($data[$pid])) {
            $arr[] = [
                'name' =>$data[$pid]['title'],
                'url' =>$data[$pid]['url']
            ] ;
            $this->cateSort($data, $data[$pid]['pid'],$level+1);
        }
        return $arr;
    }
    public function add($data){
        if(empty($data)){
            return false;
        }
        return DB::insert($this->_tabal, $data);
    }
    public function update($data, $condition){
        if(empty($data) || empty($condition)){
            return false;
        }
        return DB::update($this->_tabal, $data, $condition);
    }
}