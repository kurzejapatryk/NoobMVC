<?php
/**
 * Checks whether the variable is really empty. If it returns 1, if anything contains 0, then returns 0.
 * @param string $data
 * @return int
 */
function true_empty($data){
  if($data===0){
    return 0;
  }elseif(empty(trim($data))){
    return 1;
  }
  else{
    return 0;
  }
}

/**
 * Zamienia tablicę na ciąg znako, poszczegolne elemnty oddzielone sa przecinkiem
 * @param array $data
 * @return string
 */
function arrToStr($arr){
  if(!is_array($arr)) return $arr;
  $str = "";
  foreach($arr as $row){
    if(is_array($row)){
      $row_str = arrToStr($row);
    } else {
      $row_str = "" . $row;
    }
    $str .= $row_str . ", ";
  }
  return $str;
}
