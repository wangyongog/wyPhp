<?php
namespace WyPhp\Encrypt;
class Mcrypt{
    private $_skey = '';
    private $_sResult = '';
    public function __construct($skey=''){
        $this->_skey = $skey ? $skey : substr(CF('AUTOKEY'),4,10);
    }

    /**
     * 加密
     * @param $value
     * @return mixed
     */
    public function encrypt($value){
        for ($i = 0; $i < strlen($value); $i++) {
            $sChar = substr($value, $i, 1);
            $skeyChar = substr($this->_skey, ($i % strlen($this->_skey)) - 1, 1);
            $sChar = chr(ord($sChar) + ord($skeyChar));
            $this->_sResult .= $sChar;
        }
        $sBase64 = base64_encode($this->_sResult);
        return str_replace('=', '', strtr($sBase64, '+/', '-_'));
    }

    /**
     * 解密
     * @param $value
     * @return string
     */
    public function decrypt($value){
        $value = strtr($value, '-_', '+/');
        $value = base64_decode($value . '==');
        for ($i = 0; $i < strlen($value); $i++) {
            $sChar = substr($value, $i, 1);
            $skeyChar = substr($this->_skey, ($i % strlen($this->_skey)) - 1, 1);
            $sChar = chr(ord($sChar) - ord($skeyChar));
            $this->_sResult .= $sChar;
        }
        return $this->_sResult;
    }
}