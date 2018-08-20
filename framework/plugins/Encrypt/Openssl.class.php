<?php
namespace WyPhp\Encrypt;
use WyPhp\Error;

/**
 * openssl的rsa加密解密
 * 公钥加密 ->私钥解密
 * 私钥加密 ->公钥解密
 */
class Openssl{
    private $_privKey;
    private $_pubKey;
    private $_keyPath;
    protected $privPath;
    protected $pubPath;
    private $_sResult = '';
    private $_config = [
        'digest_alg' => 'sha1',
        'config' => 'D:\phpStudy\Apache\conf\openssl.cnf',//本地测试用，线上不要
        'private_key_bits' => 1024,
        'private_key_type' => OPENSSL_KEYTYPE_RSA
    ];
    public function __construct($path=''){
        extension_loaded('openssl') or Error::error('需要openssl扩展支持');
        $this->_keyPath = $path ? $path : FWPATH.'/plugins/ssl';
        $this->privPath = $this->_keyPath.DIRECTORY_SEPARATOR . 'key/rsa_private_key.pem';
        $this->pubPath = $this->_keyPath.DIRECTORY_SEPARATOR . 'key/rsa_public_key.pem';
        $this->createKey();
    }
    /**
     *  创建密钥文件
     */
    public function createKey(){
        if(!is_file($this->privPath) || !is_file($this->pubPath)){
            $res = openssl_pkey_new($this->_config);
            openssl_pkey_export($res, $privkey, null, $this->_config);
            if(!is_file($this->privPath)){
                $privkey and file_put_contents($this->privPath, $privkey);
            }

            if(!is_file($this->pubPath)){
                $pubkey = openssl_pkey_get_details($res);
                $pubkey = isset($pubkey['key']) ? $pubkey['key'] : '';
                $pubkey and file_put_contents($this->pubPath, $pubkey);
            }
        }
        $this->checkKey();
    }
    public function checkKey(){
        /**
         * 生成Resource类型的密钥，如果密钥文件内容被破坏，openssl_pkey_get_private函数返回false
         */
        $this->_privKey = openssl_pkey_get_private(file_get_contents($this->privPath));
        if($this->_privKey == false){
            Error::error('密钥不可用');
        }
        /**
         * 生成Resource类型的公钥，如果公钥文件内容被破坏，openssl_pkey_get_public函数返回false
         */
        $this->_pubKey = openssl_pkey_get_public(file_get_contents($this->pubPath));
        if($this->_pubKey == false){
            Error::error('公钥不可用');
        }
    }

    /**
     *   私钥加密
     */
    public function privEncrypt($str){
        if(!is_string($str)){
            return null;
        }
        $r = openssl_private_encrypt($str, $this->_sResult, $this->_privKey);
        if($r){
            return $this->urlsafe_b64encode($this->_sResult);
        }
        return null;
    }

    /**
     *   私钥解密
     */
    public function privDecrypt($str){
        if(!is_string($str)){
            return null;
        }
        $r = openssl_private_decrypt($this->urlsafe_b64decode($str) , $this->_sResult, $this->_privKey);
        if($r){
            return $this->_sResult;
        }
        return null;
    }

    /**
     * 公钥解密
     * @param $str
     * @return null|string
     */
    public function pubDecrypt($str){
        if(!is_string($str)){
            return null;
        }
        $r = openssl_public_decrypt($this->urlsafe_b64decode($str) , $this->_sResult, $this->_pubKey);
        if($r){
            return $this->_sResult;
        }
        return null;
    }

    /**
     * 公钥加密
     * @param $str
     * @return null|string
     */
    public function pubEncrypt($str){
        if(!is_string($str)){
            return null;
        }
        $r = openssl_public_encrypt($str , $this->_sResult, $this->_pubKey);
        if($r){
            return $this->urlsafe_b64encode($this->_sResult);
        }
        return null;
    }
    /**
     * 生成签名
     *
     * @param string 签名材料
     * @param string 签名编码（base64/hex/bin）
     * @return 签名值
     */
    public function sign($data){
        if (openssl_sign($data, $sign, $this->_privKey,OPENSSL_ALGO_SHA1)) {
            $sign = $this->urlsafe_b64encode($sign);
        }
        return $sign;
    }
    /**
     * RSA验签
     * $data待签名数据
     * $sign需要验签的签名
     * return 验签是否通过 bool值
     */
    public function verify($data, $sign){
        return openssl_verify($data, $this->urlsafe_b64decode($sign), $this->_pubKey,OPENSSL_ALGO_SHA1);
    }

    public function __destruct(){
        openssl_free_key($this->_privKey);
        openssl_free_key($this->_pubKey);
    }
    /**
     * 以参数形式 通过 base64_encode加密替换url 或使用urlencode
     * @param $string
     * @return mixed|string
     */
    function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    /**
     *通过url参数传值base64_decode解密出
     * @param $string
     * @return bool|string
     */
    function urlsafe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

}