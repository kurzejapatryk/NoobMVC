
<?php

    // load configs
    $conf_dir = "Configs/";
    $dir = scandir($conf_dir);
    foreach ($dir as $check_dir){
    if(is_file($conf_dir . $check_dir))
        require_once($conf_dir . $check_dir);
    }

    // load classes
    spl_autoload_register(function ($name){
        $className = (string) str_replace('\\', DIRECTORY_SEPARATOR, $name);
        require_once($className.'.class.php');
        return true;
    });