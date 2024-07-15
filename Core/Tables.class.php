<?php
namespace Core;

/**
 * Class Tables
 * Array handling class
 * @package Core
 */
class Tables{
  /**
   * Checks if a value exists in the POST array and returns it
   * @param string $key array key
   * @return mixed|false returns the value if it exists, false otherwise
   * @access public
   */
  public static function POST(string $key)
  {
    if(isset($_POST[$key])){
      return $_POST[$key];
    }else return false;
  }

  /**
   * Checks if a value exists in the GET array and returns it
   * @param string $key array key
   * @return mixed|false returns the value if it exists, false otherwise
   * @access public
   */
  public static function GET(string $key)
  {
    if(isset($_GET[$key])){
      return $_GET[$key];
    }else return false;
  }

  /**
   * Checks if a value exists in the COOKIES array and returns it
   * @param string $key array key
   * @access public
   */
  public static function COOKIE(string $key)
  {
    if(isset($_COOKIE[$key])){
      return $_COOKIE[$key];
    }
  }

  /**
   * Checks if a value exists in the SESSION array and returns it
   * @param string $key array key
   * @access public
   */
  public static function SESSION(string $key)
  {
    if(isset($_SESSION[$key])){
      return $_SESSION[$key];
    }
  }

}
