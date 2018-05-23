<?php
namespace App\Controller;
use WyPhp\Controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 15:28
 */
class baseController extends Controller {
     public function _initialize(){
         if(I('token') != substr(md5(substr(F('AUTOKEY'),16,19).date('Y-m-d H')),8) ){
             edie();
         }

     }
}