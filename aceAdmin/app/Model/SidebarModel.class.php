<?php
namespace aceAdmin\Model;
use WyPhp\DB;
use WyPhp\Model;

class SidebarModel extends Model {
    public $_tabal = 'auth_rule';
    protected $data = [];
    public function getAll(array $where=[]){
        $where = $where ? $where : [];
        $items = DB::fetch_all($this->_tabal ,'id,pid,title,url,icon,o,status',$where ,'o ASC');
        return $items;
    }
    public function sidebarList($uid){
        $data = [];
        $where['status'] = 1;
        if(!in_array($uid, CF('SYSTEM_USERID')) ) {
            $group = D('Group');
            $group_arr = $group->getGroups($uid);
            $rules = $group_arr['rules'];
            if(!$rules){
                return $this->data;
            }
            $where['id'] = ['in', $rules];
        }
        $items = DB::fetch_all($this->_tabal ,'id,pid,title,url,icon,o,status',$where ,'o ASC');
        if(empty($items)){
            return $this->data;
        }
        $this->data = getTree($items);
        return $this->data;
    }


    /**
     * 获取栏目层级,面包屑
     * @return array
     */
    public function getHeadTitle(){
        $group = D('Group');
        $rule_id = $group->authRuleId(CONTROLLER.'/'.ACTION);
        $position= [];
        if($rule_id){
            $data = $this->getAll();
            foreach ($data as $v){
                $tree[$v['id']] = [
                    'name' =>$v['title'],
                    'pid' =>$v['pid'],
                    'url' =>U($v['url'])
                ];
            }
            $position = GetTopid($tree,$rule_id);
        }
        return $position;
    }
    public function cateSort($data, $pid=0, $level=0) {
        static $arr=[];
        if(isset($data[$pid])) {
            $arr[] = [
                'name' =>$data[$pid]['title'],
                'url' =>$data[$pid]['url'],
                'home' =>$data[$pid]['pid'] ? 0 : 1
            ] ;
            $this->cateSort($data, $data[$pid]['pid'],$level+1);
        }
        return $arr;
    }
    public function add($data){
        if(empty($data)){
            return false;
        }
        return DB::insert($this->_tabal, $data);
    }
    public function update($data, $condition){
        if(empty($data) || empty($condition)){
            return false;
        }
        return DB::update($this->_tabal, $data, $condition);
    }
}