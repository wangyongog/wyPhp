<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class BannerModel extends Model {
    protected $table = 'banner';
    public function getlist($field='*', $where=[], $order='',$limit=20){
        return DB::fetch_all($this->table,$field, $where,$order,$limit);
    }
}