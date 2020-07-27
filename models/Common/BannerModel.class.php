<?php
namespace Common;
use WyPhp\DB;
use WyPhp\Model;
class BannerModel extends Model {
    protected $table = 'banner';
    public function getlist($field='*', $where=[], $order='',$limit=20){
        return DB::fetch_all($this->table,$field, $where,$order,$limit);
    }
    public function add($data){
        if (empty($data)){
            $this->error = '数据不能为空！';
            return false;
        }
        return DB::insert($this->table, $data);
    }
    public function edit($data, $where=''){
        if(empty($data)){
            $this->error = '数据不能为空！';
            return false;
        }
        if (!$where){
            $this->error = '条件不能为空！';
            return false;
        }
        return DB::update($this->table, $data, $where);
    }
    public function del($where){
        return DB::delete($this->table, $where);
    }
}