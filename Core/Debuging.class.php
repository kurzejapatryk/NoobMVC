<?php
/************************************************|
|* Description | Obsługa debugowania            *|
|************************************************/

namespace Core;

class Debuging{

  public static function getSQLDebugHTML(){
    $HTML = "";
    if(SQL_DEBUG){
      $HTML .= "<div style='z-index:100; background-color: #fff; position: absolute; padding: 25px; width: 100%; opacity: 0.9;'><H2>SQL DEBUG:</H2><br>";
      foreach($GLOBALS['SQL_DEBUG_ARRAY'] as $SQL){
        $HTML .= "<table border='1px'>";
        $HTML .= "<tr>";
        $HTML .="<td>SQL:</td><td>".$SQL['SQL']."</td></tr>";
        $HTML .= "<tr><td>VARS:</td><td>";
        $HTML .= "<table>";
        $i = 1;
        foreach($SQL['vars'] as $var){
          $HTML .= "<tr><td>".$i."</td><td>".$var."</td></tr>";
        }
        $HTML .= "</table>";
        $HTML .= "</td></tr>";
        $HTML .= "<tr><td>ERROR:</td><td>".$SQL['error']."</td></tr>";
        $HTML .= "</table><br><br>";
      }
      $HTML .= "</div>";
    }
    return $HTML;
  }

}
