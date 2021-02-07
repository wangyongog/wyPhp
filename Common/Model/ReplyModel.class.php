<?php
namespace Common\Model;
use WyPhp\DB;
use WyPhp\Model;
class ReplyModel extends Model{
    public $table = 'feedback';
    public function getList($where, $fields='*', $limit, $page, $order='id DESC'){
        return DB::fetch_all($this->table, $fields, $where,$order ,$limit, $page);
    }
    public function getNewReply($where, $fields='*', $limit, $page, $order='id DESC'){
        $data = $this->getList($where, $fields='*', $limit, $page, $order);

    }
}