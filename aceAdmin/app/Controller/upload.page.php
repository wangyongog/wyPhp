<?php
namespace App;

class upload extends baseController{
    public function actionBanner(){
        $info = upload($_FILES);
        $this->printJson($info);
    }
}