<?php
namespace App\Controller;
use WyPhp\DB;
class Error extends baseController{
    public function actionIndex(){
        exit('404');
        //$this->render();
    }
}