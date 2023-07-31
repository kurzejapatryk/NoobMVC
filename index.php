<?php
/************************************************|
|* Description | Plik inicjalizacyjny           *|
|************************************************/

// check PHP Version
if(phpversion()<'7.2' ){
  echo 'Your version of PHP is '.phpversion().'. Required min. 7.2';
  exit;
}

// start session
session_start();

// load helpers functions
require_once('helpers.php');

//Autoload NoobMCV
require_once('autoload.php');


// set debuging raporting

if( CODE_DEBUG ) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
} else {
   error_reporting(0);
   ini_set('display_errors', 0);
}

// load vendors
require_once('vendor/autoload.php');



// Load console arguments
if(isset($argv)){
  foreach ($argv as $arg) {
    $e=explode("=",$arg);
    if(count($e)==2) $_GET[$e[0]]=$e[1]; else $_GET[$e[0]]=0;
  }
}

// AntiCSRF
if(!isset($_SESSION['csrf'])){
	$csrf = hash('sha256',uniqid('yF', true).rand(1,1000));
	$_SESSION['csrf'] = $csrf;
}

require_once('Language/' . LANGUAGE . '.php');

// start
if(!isset($_GET['page'])){
  $classname = "Controllers\\" . START_CONTROLLER;
  $classname::start();
} else {
  $dir = scandir('Controllers/');
  $classname = 0;
  foreach ($dir as $check_dir){
    $check_dir = str_replace('.class.php','',$check_dir);
    if($check_dir == $_GET['page']){
      $classname = $check_dir;
    }
  }
  if($classname !='0' ){
    if(!isset($_GET['action'])){
      $classname =  START_CONTROLLER;
      $classname = "Controllers\\" . $classname;
      $classname::start();
    }else{
      $avaible_methods = get_class_methods('Controllers\\'.$classname);
      if(in_array($_GET['action'], $avaible_methods)){
        $method = $_GET['action'];
        $classname = 'Controllers\\'.$classname;
        $classname::$method();
      } else {
        Controllers\ErrorPages::e404();
      }
    }
  } else {
    Controllers\ErrorPages::e404();
  }
}
