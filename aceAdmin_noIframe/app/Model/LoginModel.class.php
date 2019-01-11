<?php
namespace aceAdmin\Model;
use WyPhp\Model;

class LoginModel extends Model {
      public function login($username='', $password=''){
          if(!$password || !$username){
               return -1;
          }
          return -1;
      }
}