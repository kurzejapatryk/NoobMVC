<?php
namespace Core;

/**
 * Class Debuging
 * Debugging handling class
 * @package Core
 */
class Debuging{

  /**
   * Function getSQLDebugHTML
   * Function returns HTML with SQL debugging
   * @return string HTML with SQL debugging
   * @access public
   */
  public static function getSQLDebugHTML() : string
  {
    $HTML = "";
    if(SQL_DEBUG){
      $HTML .= "<div style='z-index:100; background-color: #fff; color: #000; position: absolute; padding: 25px; width: 100%; opacity: 0.9;'><H2 class='text-2xl'>SQL DEBUG:</H2><br>";
      foreach($GLOBALS['SQL_DEBUG_ARRAY'] as $SQL){
        $HTML .= "<table>";
        $HTML .= "<tr class='border-2'>";
        $HTML .="<td class='pr-2 text-right border'>SQL:</td><td>".$SQL['SQL']."</td></tr>";
        $HTML .= "<tr class='border-2'><td class='pr-2 text-right border-2'>VARS:</td><td>";
        $HTML .= "<table>";
        $i = 1;
        foreach($SQL['vars'] as $var){
          $HTML .= "<tr><td>".$var."</td></tr>";
        }
        $HTML .= "</table>";
        $HTML .= "</td></tr>";
        $HTML .= "<tr class='border'><td class='pr-2 text-right border-2'>ERROR:</td><td>".$SQL['error']."</td></tr>";
        $HTML .= "</table><br><br>";
      }
      $HTML .= "</div>";
    }
    return $HTML;
  }

}
