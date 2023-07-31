<?php
if (PHP_SAPI == "cli") {

    // check PHP Version
    if(phpversion()<'7.2' ){
        echo 'Your version of PHP is '.phpversion().'. Required min. 5.5.24';
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

    $short_options = "vh";
    $long_options = ["version", "help"];
    $options = getopt($short_options, $long_options);

    if(isset($options["v"]) || isset($options["version"])) {
        echo asciArt();
        echo appInfo();
        exit;
    }

    if(isset($options["h"]) || isset($options["help"])) {
        echo asciArt();
        echo "[-h] --help       | Show helps\n"
            ."[-v] --version    | Show app and core details\n"
            ."\n";
        exit;
        
    } else {
        echo asciArt();
        echo appInfo();
        exit;
    }

} else {
    header('Location: /');
    die();
}

