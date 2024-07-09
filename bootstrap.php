<?php

// check PHP Version
if(phpversion()<'7.4' ){
    echo 'Your version of PHP is '.phpversion().'. Required min. 7.4';
    exit;
  }
  
// start session
if(!session_start()){
    echo 'Session start error!';
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ .'/helpers.php';
require_once __DIR__ .'/autoload.php';
require_once __DIR__ .'/Language/' . LANGUAGE . '.php';