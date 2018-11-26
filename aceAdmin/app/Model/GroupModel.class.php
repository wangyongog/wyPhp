<?php
namespace aceAdmin\Model;
use WyPhp\DB;
use WyPhp\Model;

class GroupModel extends Model {
    public $table = 'auth_group';
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
    public function check($url, $uid) {
        $rules = $this->getGroups($uid);
        if(empty($rules['rules'])){
            return false;
        }
        $arr = DB::fetch_all('auth_rule','url',['id'=>['in',$rules['rules']]]);
        $rules_arr = [];
        if($arr){
            foreach ($arr as $v){
                $rules_arr[] = strtolower($v['url']) ;
            }
        }
        if(!in_array('/'.$url, $rules_arr)){
            return false;
        }
        return true;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param $uid
     * @return mixed
     */
    public function getGroups($uid) {
        static $user_groups;
        if(isset($user_groups[$uid])) return $user_groups[$uid];
        $manager = D('aceAdmin/Manager');
        $user_groups[$uid] = $manager->checkLogin($uid);
        return $user_groups[$uid];
    }
}