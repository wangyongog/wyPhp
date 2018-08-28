<?php
namespace Admin\Model;
use WyPhp\DB;
use WyPhp\Model;

class GroupModel extends Model {
    public $table = 'group';
    /**
     * 获取组
     * @return mixed
     */
    public function getGroup(){
        $data = S('group');
        if(empty($data)){
            $data = DB::fetch_all($this->table,'*');
            foreach ($data as $k=> $v){
                $arr[$v['groupid']] = $v;
            }
            $data = $arr;
            S('group', $data);
        }
        return $data;
    }
}