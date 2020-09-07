<?php
namespace Common;
use WyPhp\DB;
use WyPhp\Model;
class ArchivesModel extends Model {
    public $table = 'archives';
    public function getlist($field='*', $where=[], $order='',$limit=20,$page=1){
        return DB::fetch_all($this->table,$field, $where,$order,$limit,$page);
    }
    public function getOne($field='*', $where=[]){
        $table = array(
            'archives' =>'ac',
            'left' =>'ac.arid=at.arid',
            'article' =>'at',
        );
        return DB::fetch_first($table, $field , $where);
    }
    public function add($data,$bdata){
        if (empty($data)){
            $this->error = '数据不能为空！';
            return false;
        }
        if($arid = DB::insert($this->table, $data)){
            $bdata['arid'] = $arid;
            DB::insert('article',$bdata);
        }
        return $arid;
    }
    public function edit($data,$bdata, $where=''){
        if(empty($data)){
            $this->error = '数据不能为空！';
            return false;
        }
        if (!$where){
            $this->error = '条件不能为空！';
            return false;
        }
        if(DB::update($this->table, $data,$where) || DB::update('article',$bdata,$where)){
            return true;
        }
        return false;
    }
    public function del($where){
        if(DB::delete($this->table, $where)){
            DB::delete('article', $where);
            return true;
        }
        return false;
    }
}