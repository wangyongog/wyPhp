<?php
namespace aceAdmin\Model;
use App\Controller\baseController;
use WyPhp\DB;
use WyPhp\Model;

class SidebarModel extends Model {
    public $_tabal = 'auth_rule';
    protected $data = [];
    public function getAll(){
        $items = S('sidebarlistall');
        if($items){
            return $items;
        }
        $items = DB::fetch_all($this->_tabal ,'id,pid,title,url,icon,o,status',[] ,'o ASC');
        S('sidebarlistall' ,$items);
        return $items;
    }
    public function sidebarList($uid){
        $data = [];
        $where['status'] = 1;
        if(!in_array($uid, CF('SYSTEM_USERID')) ) {
            $group = D('aceAdmin/Group');
            $group_arr = $group->getGroups($uid);
            $rules = $group_arr['rules'];
            if(!$rules){
                return $this->data;
            }
            $where['id'] = ['in', $rules];
        }
        $items = DB::fetch_all($this->_tabal ,'id,pid,title,url,icon,o,status',$where ,'o ASC');
        if(empty($items)){
            return $this->data;
        }
        $this->data = getTree($items);
        S('sidebarlist'.$uid ,$this->data);
        return $this->data;
    }


    /**
     * 获取栏目层级,面包屑
     * @return array
     */
    public function getHeadTitle(){
        $arr = S('breadcrumbs');
        $data = $arrlist = [];
        if(empty($arr)){
            $arr = DB::fetch_all($this->_tabal ,'id,pid,title,url',[] ,'o ASC');
            S('breadcrumbs', $arr);
        }
        list($act, $par) = explode('?', $_SERVER['REQUEST_URI']);
        foreach($arr as $value){
            if(rtrim($act, CF('URL_HTML_FIX'))  == strtolower($value['url'])){
                $data[] = [
                    'name' =>$value['title'],
                    //'url' =>$value['url'],
                    'last' =>1
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
                'url' =>$data[$pid]['url'],
                'home' =>$data[$pid]['pid'] ? 0 : 1
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