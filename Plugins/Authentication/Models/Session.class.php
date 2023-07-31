<?php
/************************************************|
|* Author      | Patryk Kurzeja                 *|
|* Date        | 13-01-2019                     *|
|* email       | p.kurzeja@spheresystems.pl     *|
|* Description | Model uzytkownika              *|
|************************************************/


namespace Plugins\Authentication\Models;

use Core\Model;
use Core\Db;

class Session extends Model{

  public $id;                //INTEGER AUTO_INCREMENT INIQUE PRIMARY_KEY
  
  protected static $table = 'sessions';

  protected static $schema = [
    'id' => "INT PRIMARY KEY",
    'session_id' => "VARCHAR(100) NOT NULL",
    'user_id' => "INT NOT NULL",
    'auth_key' => "VARCHAR(255) NOT NULL",
    'created_datetime' => "TIMESTAMP NOT NULL",
    'email' => "VARCHAR(255) NOT NULL",
    'expire_datetime' => "VARCHAR(255) NOT NULL",
  ];

  public $session_id;
  public $user_id;
  public $auth_key;
  public $created_datetime;
  public $expire_datetime;

  public function getBySessionID($id){
    $table = $this->table;
    if($id){
      $SQL = "SELECT * FROM ".$table." WHERE session_id = ? LIMIT 1";
      $params = Db::select($SQL, array($id), true);
      if(!empty($params)){
        foreach($params as $key => $val){
          $this->{$key} = $val;
        }
      }

    }
    return $this;
  }
}
