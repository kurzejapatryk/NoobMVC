<?php

namespace Models;

use Core\Model;
use Core\Db;

/**
 * User Class
 * User model
 * @package Plugins\Authentication\Models
 */
class User extends Model{

  /**
   * Table name
   * @var string
   * @access protected
   */
  protected static $table = 'users';

  /**
   * Table schema
   * @var array
   * @access protected
   */
  protected static $schema = array(
    'id' => "INT PRIMARY KEY AUTO_INCREMENT",
    'created_time' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    'user_name' => "VARCHAR(100) NOT NULL UNIQUE",
    'name' => "VARCHAR(100)",
    'surname' => "VARCHAR(100)",
    'password' => "VARCHAR(255) NOT NULL",
    'email' => "VARCHAR(255) UNIQUE",
    'role' => "INT",
    'notes' => "TEXT",
  );

  /**
   * User ID
   * @var int
   * @access public
   */
  public $id;

  /**
   * Creation date
   * @var string
   * @access public
   */
  public $created_time;

  /**
   * User name
   * @var string
   * @access public
   */
  public $user_name;

  /**
   * User first name
   * @var string
   * @access public
   */
  public $name;

  /**
   * User last name
   * @var string
   * @access public
   */
  public $surname;

  /**
   * User password
   * @var string
   * @access protected
   */
  protected $password;

  /**
   * User email address
   * @var string
   * @access public
   */
  public $email;

  /**
   * User role
   * @var int
   * @access public
   */
  public $role;

  /**
   * User notes
   * @var string
   * @access public
   */
  public $notes;

  /**
   * Get user by username
   * @param string $user_name
   * @return User|false
   * @access public
   */
  public function getByUserName(string $user_name) : User|false
  {
    $table = self::$table;
    if($user_name){
      $SQL = "SELECT * FROM ".$table." WHERE user_name = ? LIMIT 1";
      $params = Db::select($SQL, array($user_name), true);
      if(is_array($params)){
        foreach($params as $key => $val){
          $this->{$key} = $val;
        }
      } else return false;
    }
    return $this;
  }

  /**
   * Get user by email
   * @param string $email
   * @return User|false
   * @access public
   */
  public function getByEmail(string $email) : User|false
  {
    $table = self::$table;
    if($email){
      $SQL = "SELECT * FROM ".$table." WHERE email = ? LIMIT 1";
      $params = Db::select($SQL, array($email), true);
      if(is_array($params)){
        foreach($params as $key => $val){
          $this->{$key} = $val;
        }
      } else return false;
    }
    return $this;
  }

  /**
   * Set password
   * @param string $password
   * @return void
   * @access public
   */
  public function setPassword(string $password) : void
  {
    $this->password = md5($password.SALT);
  }

  /**
   * Get password
   * @return string hashed password
   * @access public
   */
  public function getPassword() : string
  {
    return $this->password;
  }
}
