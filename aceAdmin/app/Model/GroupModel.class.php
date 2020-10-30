<?php
namespace aceAdmin\Model;
use WyPhp\DB;
use WyPhp\Model;

class GroupModel extends Model {
    public $table = 'auth_group';
    public $user_rules = [];
    /**
     * 获取组
     * @return mixed
     */
    public function getGroup(){
        if(empty($data)){
            $data = DB::fetch_all($this->table,'*');
            foreach ($data as $k=> $v){
                $arr[$v['groupid']] = $v;
            }
            $data = $arr;
        }
        return $data;
    }

    /**获取操作ID
     * @param $action
     */
    public function authRuleId($action){
        return DB::result_first('auth_rule','id',['url'=>ucfirst($action)]);
    }

    /**
     * 判断是否有权限
     * @param string $url
     * @param int $uid
     * @return bool
     */
    public function checks($url='', $uid=0) {
        $rules = $this->getGroups($uid);
        if(empty($rules['rules'])){
            return false;
        }
        $arr = DB::fetch_all('auth_rule','url,id',['id'=>['in',$rules['rules']]]);
        $rulesData = ['main/index'];
        if($arr){
            foreach ($arr as $v){
                list($c, $a) = $v['url'] ? explode('/', $v['url']) : [];
                $rulesData[] = $c ? strtolower($c.'/'.($a?$a:\APPbase::$view)) : '';
            }
            $rulesData = array_filter($rulesData);
        }
        $this->user_rules = $rulesData;
        if(!in_array($url, $rulesData)){
            return false;
        }
        return true;
    }

    /**判断是否显示
     * @param $uid
     * @param $action
     * @return bool
     */
    public function checkShowAction($action){
        if(!in_array(\APPbase::$user['uid'], CF('SYSTEM_USERID')) ) {
            return in_array($action, $this->user_rules);
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
        $manager = new ManagerModel();
        $user_groups[$uid] = $manager->checkLogin($uid);
        return $user_groups[$uid];
    }
}