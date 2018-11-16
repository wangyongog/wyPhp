<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class ManagerModel extends Model{
    public $table = 'attachments';
    public function add($data){
        if(!$data)return;
        return DB::multi_insert($this->table, $data);
    }
    public function get($attid, $stype=1){
        $where['attid'] = $attid;
        $where['stype'] = $stype;
        return DB::fetch_all($this->table,'*', $where);
    }
}