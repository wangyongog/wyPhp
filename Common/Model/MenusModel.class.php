<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class MenusModel extends Model {
    public $table = 'menus';
    public function getlist($field='*', $where=[], $order='',$limit=20){
        return DB::fetch_all($this->table,$field, $where,$order,$limit);
    }

    /**
     * 后期后端栏目
     * @param array $where
     * @param string $fields
     * @param bool $isweb
     * @return array|mixed
     */
    public function getMenus($where=[], $fields='*'){
        return DB::fetch_all($this->table ,$fields,$where,'weight asc,typeid asc');
    }
    /**前端栏目
     * @param string $field
     * @param array $where
     * @return array|mixed
     */
    public function getWebMenus($field='typeid,typename,pid,url,keywords,siteurl,description', $where=['ishide'=>1]){
        $cacheId = 'webmenus'.implode('',$where);
        $c_data = S($cacheId);
        if($c_data){
            return $c_data;
        }
        $items = DB::fetch_all($this->table ,$field,$where,'weight asc,typeid asc');
        $items = getTree($items,'typeid');
        S($cacheId ,$items);
        return $items;
    }
    public function add($data){
        if(empty($data)){
            return false;
        }
        return DB::insert($this->table, $data);
    }
    public function update($data, $condition){
        if(empty($data) || empty($condition)){
            return false;
        }
        return DB::update($this->table, $data, $condition);
    }
    public function del($condition){
        return DB::delete($this->table, $condition);
    }
}