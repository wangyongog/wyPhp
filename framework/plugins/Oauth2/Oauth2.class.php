<?php
//oauth2.0使用于单点登录身份认证
namespace WyPhp\Oauth2;
use WyPhp\Encrypt\Openssl;
class Oauth2 {
    //客户端ID
    protected $client_id = '';
    //客户端传自定义参数
    protected $state = '';
    //回调URL
    protected $redirect_url = '';
    //返回数据
    protected $data = [];
    protected $expires = 7200;
    public function __construct(){

    }

    /**
     * 获取设备唯一ID
     *
     */
    public function CreateID(){
        $ssl = new Openssl();
        ///$this->data['client_id'] = creatToken(uniqid(),random(3).TIMESTAMP,10);
        $randId = $ssl->privEncrypt(random(4).uniqid());
        $this->data['client_id'] = substr($randId,8,20) ;
        S($this->data['client_id'], $this->data['client_id'], $this->expires);
        return $this->data;
    }
    /**
     *获取code
     */
    public function Authorize(){
        $this->outData['code'] = creatToken(uniqid(),random(6).TIMESTAMP,20);
        S($this->client_id.'_code', $this->outData['code'],1800);
        $this->printJson();
    }

    /**
     *code 交换access_token
     */
    public function AccessToken($code){
        $code = I('code');
        $this->outData['access_token'] = '';
        $this->outData['expires_in'] = '';
        $this->outData['refresh_token'] = '';
    }
}