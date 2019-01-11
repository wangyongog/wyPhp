<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class MenusModel extends Model {
    public $table = 'menus';
    public function getlist($field='*', $where=[], $order='',$limit=20){
        return DB::fetch_all($this->table,$field, $where,$order,$limit);
    }
    public function getWebMenus($field='typeid,typename,pid,url,keywords,siteurl,description', $where=['stype'=>1,'ishide'=>1]){
        $cacheId = 'webmenus'.implode('',$where);
        $c_data = S($cacheId);
        if($c_data){
            return $c_data;
        }
        $items = DB::fetch_all($this->table ,$field,$where,'weight asc');
        $items = getTree($items,'typeid');
        S($cacheId ,$items);
        return $items;
    }

}