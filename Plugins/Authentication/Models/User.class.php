<?php

namespace Plugins\Authentication\Models;

use Core\Model;
use Core\Db;

class User extends Model{

  public $id;                //INTEGER AUTO_INCREMENT INIQUE PRIMARY_KEY
  
  protected static $table = 'users';
  protected static $schema = array(
    'id' => "INT PRIMARY KEY",
    'user_name' => "VARCHAR(100) NOT NULL UNIQUE",
    'name' => "VARCHAR(100)",
    'surname' => "VARCHAR(100)",
    'password' => "VARCHAR(255) NOT NULL",
    'email' => "VARCHAR(255) UNIQUE",
    'role' => "INT"
  );

  public $user_name;
  public $name;
  public $surname;
  protected $password;
  public $email;
  public $role;


  public function getByUserName($user_name){
    $table = $this->table;
    if($user_name){
      $SQL = "SELECT * FROM ".$table." WHERE user_name = ? LIMIT 1";
      $params = Db::select($SQL, array($user_name), true);
      foreach($params as $key => $val){
        $this->{$key} = $val;
      }
    }
    return $this;
  }

  public function setPassword($password){
    $this->password = md5($password.SALT);
  }

  public function getPassword(){
    return $this->password;
  }
}
