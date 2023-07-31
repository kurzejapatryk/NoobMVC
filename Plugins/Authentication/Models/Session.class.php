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
  public $table = 'sessions';

  public $session_id;
  public $user_id;
  public $auth_key;
  public $create_datetime;
  public $expired_datetime;


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
