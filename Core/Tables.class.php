<?php
/************************************************|
|* Author      | Patryk Kurzeja                 *|
|* Date        | 15-11-2017                     *|
|* email       | p.kurzeja@spheresystems.pl     *|
|* Project     | SphereFramefork                *|
|* Description | Obsługa tablic                 *|
|************************************************/

namespace Core;

class Tables{
  /**
   * Sprawdza czy istnieje i zwraca wartość z tablicy POST
   * @author Patryk Kurzeja <p.kurzeja#spheresystems.pl>
   * @param string $key klucz tablicy
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function POST($key){
    if(isset($_POST[$key])){
      return $_POST[$key];
    }else return false;
  }

  /**
   * Sprawdza czy istnieje i zwraca wartość z tablicy GET
   * @author Patryk Kurzeja <p.kurzeja#spheresystems.pl>
   * @param string $key klucz tablicy
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function GET($key){
    if(isset($_GET[$key])){
      return $_GET[$key];
    }else return false;
  }

  /**
   * Sprawdza czy istnieje i zwraca wartość z tablicy COOKIES
   * @author Patryk Kurzeja <p.kurzeja#spheresystems.pl>
   * @param string $key klucz tablicy
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function COOKIES($key){
    if(isset($_COOKIES[$key])){
      return $_COOKIES[$key];
    }
  }
}
