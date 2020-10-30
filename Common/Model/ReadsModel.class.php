<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class ReadsModel extends Model{
    public $table = 'reads';
    public function add($data){
        $rdata['tid'] = isset($data['tid']) ? $data['tid'] : 0;
        $rdata['url'] = isset($data['url']) ? $data['url'] : '';
        $rdata['stype'] = isset($data['type']) ? $data['type'] : '';
        $rdata['isgaosu'] = $rdata['stype'] == 'gaosu' ? 1 : 0;
        $rdata['addtime'] = TIMESTAMP;
        $rdata['count'] = isset($data['count']) ? $data['count'] : 0;
        return DB::insert($this->table, $rdata);
    }
    public function close($tid=0){
        if(!$tid) return false;
        return DB::update($this->table, ['ispao'=>1], array('tid'=>$tid));
    }
}