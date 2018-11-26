<?php
namespace aceAdmin\Model;
use WyPhp\DB;
use WyPhp\Model;

class BannerModel extends Model {
    public $table = 'banner';
    protected $error;
    public function getError(){
        return $this->error;
    }
    public function get($field, $where, $order='',$limit=10){

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
        return DB::update($this->table, $data, $data);
    }
    public function del($where){
        return DB::delete($this->table, $where);
    }
}