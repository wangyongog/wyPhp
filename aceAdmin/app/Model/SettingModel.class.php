<?php
namespace aceAdmin\Model;
use WyPhp\DB;
use WyPhp\Model;

class SettingModel extends Model{
    public $table = 'setting';
    /**
     * 网站配置获取函数
     * @param string $key
     * @param int $type
     * @return array|mixed
     */
    public function get_setting($key=''){
        $data = S('setting');
        $map = [];
        if(empty($data)){
            $arr = DB::fetch_all($this->table, '*');
            if($arr){
                foreach ($arr as $v){
                    $data[$v['k']] = $v;
                }
                $data = serialize($data);
                S('setting', $data);
            }
        }
        $data = $data ? unserialize($data) : [];
        return $key ? $data[$key] : $data;
    }
}