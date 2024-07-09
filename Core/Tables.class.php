<?php
/************************************************|
|* Description | Array handling                 *|
|************************************************/

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
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function POST($key){
    if(isset($_POST[$key])){
      return $_POST[$key];
    }else return false;
  }

  /**
   * Checks if a value exists in the GET array and returns it
   * @param string $key array key
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function GET($key){
    if(isset($_GET[$key])){
      return $_GET[$key];
    }else return false;
  }

  /**
   * Checks if a value exists in the COOKIES array and returns it
   * @param string $key array key
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function COOKIES($key){
    if(isset($_COOKIES[$key])){
      return $_COOKIES[$key];
    }
  }
}
