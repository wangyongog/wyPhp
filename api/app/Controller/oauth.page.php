<?php
//oauth2.0使用于单点登录身份认证
namespace App\Controller;
use WyPhp\Controller;
use WyPhp\Encrypt\Openssl;
use WyPhp\Oauth2\Oauth2;

class oauth extends Controller{
    //客户端ID
    protected $client_id = '';
    //客户端传自定义参数
    protected $state = '';
    //回调URL
    protected $redirect_url = '';
    protected $oauth = null;
    public function _initialize(){
        $this->client_id = I('client_id');
        $this->state = I('state');
        $this->redirect_url = I('url');
        $this->oauth = new Oauth2();
    }
    protected function checkClientId(){
        if(empty(S($this->client_id)) || empty($this->client_id)){
            $this->error('设备ID无效');
        }
    }
    /**
     * 获取设备唯一ID
     *
     */
    public function actionIndex(){
        $this->outData = $this->oauth->CreateID();
        $this->success();
    }

    /**
     *获取code
     */
    public function actionAuthorize(){
        $this->checkClientId();
        $this->outData['state'] = $this->state;
        $this->outData['code'] = creatToken(uniqid(),random(6).TIMESTAMP,20);
        S($this->client_id.'_code', $this->outData['code'],1800);
        $this->printJson();
    }

    /**
     *code 换取access_token
     */
    public function actionAccess_token(){
        $code = I('code');
        $this->outData['access_token'] = '';
        $this->outData['expires_in'] = '';
        $this->outData['refresh_token'] = '';
    }

    /**
     *
     */
    public function actionRefresh_token(){

    }
}