<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../framework/APPbase.php';
class APP extends APPbase{
    static function runBefore(){
    }
}
APPbase::run();