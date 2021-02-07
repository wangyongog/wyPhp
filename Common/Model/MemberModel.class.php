<?php
namespace Common\Model;
use WyPhp\Model;
use WyPhp\DB;

class MemberModel extends Model {
    public $table = 'member';
    /* 用户模型自动验证 */
    protected $_validate = array(
        array('username', '1,16', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
        array('username', '', -3, self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        array('password', '6,30', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法
        array('password1', 'password', -9, self::EXISTS_VALIDATE, 'confirm'), //密码长度不合法
        array('phone','require',-8,self::MUST_VALIDATE),
        array('phone','',-5,self::EXISTS_VALIDATE,'unique'),
    );
    /* 用户模型自动完成 */
    protected $_auto = array(
        array('addtime', TIMESTAMP, self::MODEL_INSERT),
        array('grade', 1, self::MODEL_INSERT),
        array('status', 1, self::MODEL_INSERT),
        array('ip', 'getIP', self::MODEL_INSERT, 'function', 1),
        array('hash', 'random', self::MODEL_INSERT, 'function', 6),
        array('password', 'creatPassWorld', self::MODEL_BOTH, 'callback')
    );
    public function member($condition=null, $fields='*'){
        return DB::fetch_first($this->table ,$fields, $condition);
    }
    public function register($data=[]){
        if(empty($data)){
            return false;
        }
        if($this->validate($data) == false) return $this->getError();
        $data = $this->autoOperation($data);
        return DB::insert($this->table, $data);
    }
    public function login($username='', $password='',$map =0){
        if(!$password || !$username){
            return -1;
        }
        $data = DB::fetch_first($this->table, 'uid,password,hash' ,array('username'=>trim($username),'status'=>1,'map' =>$map));
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
            session('uidMb', null);
            return;
        }
        $data['hash'] = random();
        $data['ip'] = getIP(1);
        $data['lasttime'] = TIMESTAMP;
        $uidhash = mcrypt($uid."\t".$data['hash']);
        session('uidMb', $uidhash);
        DB::update($this->table, $data,array('uid'=>$uid));
    }
    public function getUsername($uid=0){
        if(!$uid){
            return false;
        }
        $memberArr = S('members');
        if(!empty($memberArr[$uid]) ){
            return $memberArr[$uid] ;
        }
        $data = DB::fetch_all($this->table,'username,uid',array('uid'=>array('gt',0)));
        foreach ($data as $val){
            $members[$val['uid']] = $val['username'];
        }
        S('members', $members);
        return $members[$uid];
    }
    /**
     * @return string
     */
    public function custom_function_for_salt(){
        return substr(md5(uniqid(mt_rand(1,99999), true).substr(F('AUTOKEY'),12)), 0, 22);
    }
    /**
     * 创建密码
     * @param $password
     */
    public function creatPassWorld($password=''){
        $options = [
            'salt' => $this->custom_function_for_salt(),
            'cost' => 10 // the default cost is 10
        ];
        if($password){
            return password_hash(substr(F('AUTOKEY'),10,6).trim($password) .substr(F('AUTOKEY'),10), PASSWORD_DEFAULT);
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
        return password_verify(substr(F('AUTOKEY'),10,6).trim($password).substr(F('AUTOKEY'),10), $hashPwd);
    }
    /**
     * 获取用户注册错误信息
     *
     * @param integer $code
     *        	错误编码
     * @return string 错误信息
     */
    public function showRegError($code = 0) {
        switch ($code) {
            case - 1 :
                $error = '用户名长度必须在16个字符以内！';
                break;
            case - 3 :
                $error = '用户名被占用！';
                break;
            case - 4 :
                $error = '密码长度必须在6-30个字符之间！';
                break;
            case - 5 :
                $error = '手机号码已被注册！';
                break;
            case - 6 :
                $error = 'QQ号码已被占用';
                break;
            case - 7 :
                $error = '微信号已被占用';
                break;
            case - 8 :
                $error = '请填写11位手机号码';
                break;
            case - 9 :
                $error = '2次密码不一致！';
                break;
            case - 10 :
                $error = '请填写微信';
                break;
            case - 11 :
                $error = '请填写QQ';
                break;
            case - 12 :
                $error = '请填写邀请码';
                break;
            case - 13 :
                $error = '邀请码有误！';
                break;
            default :
                $error = '未知错误';
        }
        return $error;
    }
}