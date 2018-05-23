<?php
namespace Admin\Model;
use WyPhp\DB;
use WyPhp\Model;

class SidebarModel extends Model {
    private $_tabal = 'auth_rule';
    public function ss($fields='*', $condition=null, $order='o ASC', $limit='', $page=0){
        return DB::fetch_all($this->_tabal ,$fields, $condition,$order);
    }
    public function sidebarList($items=array(), $id = 'id', $pid = 'pid', $son = 'children'){
        $tree = array();
        $tmpMap = array();
        $items = DB::fetch_all($this->_tabal ,'*',array('status'=>1),'o ASC');
        foreach($items as $item ){
            if( $item['pid']==0 ){
                $father_ids[] = $item['id'];
            }
        }
        foreach ($items as $item) {
            $tmpMap[$item[$id]] = $item;
        }

        foreach ($items as $item) {
            if( $item['pid'] && !in_array( $item['pid'], $father_ids )){
                continue;
            }
            if (isset($tmpMap[$item[$pid]])) {
                $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
            } else {
                $tree[] = &$tmpMap[$item[$id]];
            }
        }
        return $tree;
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