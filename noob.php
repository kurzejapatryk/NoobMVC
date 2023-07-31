<?php
if (PHP_SAPI == "cli") {

    // check PHP Version
    if(phpversion()<'7.2' ){
        echo 'Your version of PHP is '.phpversion().'. Required min. 7.2';
        exit;
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // load vendors
    require_once('vendor/autoload.php');

    // load helpers functions
    require_once('helpers.php');

    //Autoload NoobMCV
    require_once('autoload.php');

    $short_options = "vhi::";
    $long_options = ["version", "help", "init::"];
    $options = getopt($short_options, $long_options);

    if(isset($options["v"]) || isset($options["version"])) {
        echo asciArt();
        echo appInfo();
        exit;
    }
    elseif(isset($options["h"]) || isset($options["help"])) {
        echo asciArt();
        echo "[-h] --help       | Show helps\n"
            ."[-v] --version    | Show app and core details\n"
            ."\n";
        exit;
    }
    elseif(isset($options["i"]) || isset($options["init"])){

        echo Plugins\Authentication\Models\User::createTable()."\n";
        echo Plugins\Authentication\Models\Session::createTable()."\n\n";

        $password = isset($options['i']) ? $options['i'] : $options['init'];
        if(strlen($password) >= 8){
            $user = new Plugins\Authentication\Models\User();
            $user->user_name = "admin";
            $user->setPassword($password);
            $user->role = 1;
            $user->save();
            echo "User 'admin' is added ok! Password is ".$password.".";
        }elseif(strlen($password) < 8 && strlen($password) > 0){
            echo "Password is too short. Minimum lenght is 8 chars.";
        }
        else {
            echo "You no definied password, user create is skipped.";
        }

    } else {
        echo asciArt();
        echo appInfo();
        exit;
    }

} else {
    header('Location: /');
    die();
}

