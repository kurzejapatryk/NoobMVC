<?php
/**
 * Checks whether the variable is really empty. If it returns 1, if anything contains 0, then returns 0.
 * @param string $data
 * @return int
 */
function true_empty($data){
  if($data===0){
    return 0;
  }elseif(empty(trim((string)$data))){
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

function asciArt(){
  return "===================================================\n" 
        ."  _   _             _     __  __  _______      __  \n"
        ." | \ | |           | |   |  \/  |/ ____\ \    / /  \n"
        ." |  \| | ___   ___ | |__ | \  / | |     \ \  / /   \n"
        ." | . ` |/ _ \ / _ \| '_ \| |\/| | |      \ \/ /    \n"
        ." | |\  | (_) | (_) | |_) | |  | | |____   \  /     \n"
        ." |_| \_|\___/ \___/|_.__/|_|  |_|\_____|   \/      \n"
        ."                                           \e[34mv".CORE_VERSION."\e[39m\n"
        ."===================================================\n\n"
        ."\e[96mNoobMVC\e[39m by \e[34mPatryk Kurzeja \e[90m<patrykkurzeja@proton.me> \e[39m\n"
        ."\e[90mhttps://github.com/kurzejapatryk/NoobMVC\e[39m\n"
        ."---------------------------------------------------\n\n";
}

function appInfo() {
  return "   App name:      " . APP_NAME . "\e[39m\n"
  ."   URL:           " . URL . "\e[39m\n\n"
  ."   Core version:  \e[93m" . CORE_VERSION. "\e[39m\n\n";
}
