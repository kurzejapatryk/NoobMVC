<?php
namespace Models;

use Core\Model;
use Core\Db;

/**
 * Class Session
 * User model
 * @package Plugins\Authentication\Models
 */
class Session extends Model{

  /**
   * Table name
   * @var string  
   */
  protected static $table = 'sessions';

  /**
   * Table schema
   * @var array
   */
  protected static $schema = [
    'id' => "INT PRIMARY KEY AUTO_INCREMENT",
    'session_id' => "VARCHAR(100) NOT NULL",
    'user_id' => "INT NOT NULL",
    'auth_key' => "VARCHAR(255) NOT NULL",
    'created_datetime' => "TIMESTAMP NOT NULL",
    'expire_datetime' => "INT",
  ];

  /**
   * Record ID
   * @var int
   */
  public $id;

  /**
   * Session ID
   * @var string
   */
  public $session_id;

  /**
   * User ID
   * @var int
   */
  public $user_id;

  /**
   * Authorization key
   * @var string
   */
  public $auth_key;

  /**
   * Creation date and time
   * @var string
   */
  public $created_datetime;

  /**
   * Expiration date and time
   * @var int
   */
  public $expire_datetime;

  /**
   * Get session by ID
   * @param int $id
   * @return object
   */
  public function getBySessionID($id){
    $table = self::$table;
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
