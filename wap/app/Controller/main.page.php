<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 14:38
 */
namespace App\Controller;
use WyPhp;
class main extends WyPhp\Controller{
    public function __construct($islogin =false){
        parent::__construct($islogin);
    }
    public function actionIndex(){
        print_r(WyPhp\APP::get('s'));
        //echo 'sssss';exit;
    }
}