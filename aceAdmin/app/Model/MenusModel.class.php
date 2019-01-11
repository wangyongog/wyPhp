<?php
namespace aceAdmin\Model;
use WyPhp\DB;
use WyPhp\Model;

class MenusModel extends Model {
    public $table = 'menus';
    protected $data = [];
    public function getAll($where=[], $fields='*',$isweb=false){
        $stype = isset($where['stype']) ? 1 : '';
        if($isweb){
            $stype = implode('',$where);
        }
        $cacheId = 'menus'.$stype;
        $c_data = S($cacheId);
        if($c_data){
            return $c_data;
        }

        $items = DB::fetch_all($this->table ,$fields,$where,'weight asc');
        if($stype){
            $items = getTree($items,'typeid');
        }
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