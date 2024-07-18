<?php
/************************************************|
|* Description | Plik inicjalizacyjny           *|
|************************************************/

//Autoload NoobMCV
require_once __DIR__ .'/bootstrap.php';

// start session
if(!session_start()){
  echo 'Session start error!';
  exit;
}

// set debuging raporting

if( CODE_DEBUG ) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
} else {
   error_reporting(0);
   ini_set('display_errors', 0);
}


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

// start
$method = false;
$classname = false;
if(!isset($_GET['page'])){
  $classname = "Controllers\\" . START_CONTROLLER;
  $classname::start();
} else {
  $dir = scandir('Controllers/');
  $classname = 0;
  foreach ($dir as $check_dir){
    $check_dir = str_replace('.class.php','',$check_dir);
    if($check_dir == ucwords($_GET['page']) && $_GET['page'] != 'Uploads'){
      $classname = $check_dir;
    }
  }
  if($classname !='0' ){
    if(!isset($_GET['action'])){
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
