<?php
namespace Common\Model;
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
}