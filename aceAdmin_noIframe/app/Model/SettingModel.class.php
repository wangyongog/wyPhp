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
    public function get_setting($key='', $type=0){
        $data = S('setting'.$type);
        $map['type'] = $type;
        if($type === 'all'){
            $data = $map = array();
        }
        if(empty($data)){
            $arr = DB::fetch_all($this->table, '*',$map);
            if($arr){
                foreach ($arr as $k=> $v){
                    $data[$v['type']][$v['k']] = unserialize($v['value']) ? unserialize($v['value']) : $v['value'];
                }
                $type !== 'all' and $data = $data[$type];
                S('setting'.$type ,serialize($data),3600*8);
            }
        }else{
            $data = unserialize($data);
        }
        return $key ? $data[$key] : $data;
    }
}