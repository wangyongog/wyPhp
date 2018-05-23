<?php
namespace App\Controller;
use WyPhp\Controller;
use WyPhp\Filter;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 15:59
 */
class goods extends Controller{
     public function _initialize()
     {
         // TODO: Implement _initialize() method.
     }
    public function actionIndex(){
         print_r(Filter::$gp);
    }
}