<?php
namespace WyPhp\Session;
class Redis extends \SessionHandler{
    protected $hand;
    function __construct($config = []){
        if(empty($this->hand)){
            $this->hand = new \WyPhp\Cache\Redis($config);
        }
    }
    function open($save_path, $session_id){
        return true;
    }
    function close(){
        return $this->hand->close();
    }
    function read($sid){
        return $this->hand->get($sid);
    }
    function write($sid, $value){
        return $this->hand->set($sid, $value);
    }
    function destroy($sid){
        return $this->hand->delete($sid);
    }
    function gc($maxlifetime=0){
        return true;
    }
}