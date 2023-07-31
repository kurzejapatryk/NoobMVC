<?php
namespace Plugins\Authentication\Models;

use Core\Model;
use Core\Db;

class User extends Model{

  public $id;                //INTEGER AUTO_INCREMENT INIQUE PRIMARY_KEY
  public $table = 'users';

  public $user_name;
  public $name;
  public $surname;
  public $password;
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
}
