<?php
namespace Admin\Model;
use WyPhp\DB;
use WyPhp\Model;
class ManagerModel extends Model{
    public $table = 'admin';
    /* 用户模型自动验证 */
    protected $_validate = array(
        array('user', '5,16', '用户名长度必须在16个字符以内', self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
        array('user', '', '用户名被占用！', self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        //array('password', 'require', '3333', self::MUST_VALIDATE, ''),
        array('password', '6,30', '密码长度必须在6-30个字符之间！', self::EXISTS_VALIDATE, 'length'), //密码长度不合法
        array('password1', 'password', '2次密码不一致！', self::EXISTS_VALIDATE, 'confirm'), //密码长度不合法
    );
    /* 用户模型自动完成 */
    protected $_auto = array(
        array('addtime', TIMESTAMP, self::MODEL_INSERT),
        array('ip', 'getIP', self::MODEL_INSERT, 'function', 1),
        array('password', 'creatPassWorld', self::MODEL_BOTH, 'callback')
    );
    public function getAdminUser($uid=0){
        if(!$uid) return false;
        if(S('admin'.$uid)){
            return S('admin'.$uid);
        }
        $data = DB::fetch_first($this->table, 'uid,groupid,user,hash,lasttime,addtime',array('uid'=>$uid));
        !empty($data) and S('admin'.$uid, $data);
        return $data;
    }
    public function login($username='', $password=''){
        if(!$password || !$username){
            return -1;
        }
        $data = DB::fetch_first($this->table, 'uid,password,hash' ,array('user'=>$username,'status'=>1));
        if(empty($data)){
           return -1;
        }
        if($this->pwdVerify($password, $data['password'] ) != true){
            return -2;
        }
        $this->_updateLogin($data['uid']); //更新用户登录信息
        return $data['uid']; //登录成功，返回用户ID
    }
    private function _updateLogin($uid){
        if(!$uid){
            session('uidHahs', null);
            return;
        }
        $data['hash'] = random();
        $data['ip'] = getIP(1);
        $data['lasttime'] = TIMESTAMP;
        $uidhash = mcrypt($uid."\t".$data['hash']);
        session('uidHahs', $uidhash);
        DB::update($this->table, $data,array('uid'=>$uid));
    }
    public function add($data=[]){
        if(empty($data)){
            return false;
        }
        if($this->validate($data) == false) return false;
        $data = $this->autoOperation($data);
        unset($data['password1']);
        return DB::insert($this->table, $data);
    }
    public function update($data=[],$uid=0){
        if(empty($data) || !$uid){
            return false;
        }
        if($this->validate($data) == false) return false;
        if(isset($data['password'])){
            $data['password'] = $this->creatPassWorld($data['password']);
            unset($data['password1']);
        }
        return DB::update($this->table, $data,array('uid'=>intval($uid)));
    }
    /**
     * 创建密码
     * @param $password
     */
    public function creatPassWorld($password=''){
        $password = $password ? $password : I('password');
        /*$options = [
            'salt' => $this->custom_function_for_salt(),
            'cost' => 10 // the default cost is 10
        ];*/
        if($password){
            return password_hash(trim($password) .substr(F('AUTOKEY'),2,12), PASSWORD_DEFAULT);
        }
        return false;
    }

    /**
     * 密码验证
     * @param $password 明文密码
     * @param $hash 加密后的哈希密码
     * @return bool
     */
    public function pwdVerify($password, $hashPwd){
        return password_verify($password.substr(F('AUTOKEY'),2,12), $hashPwd);
    }
}