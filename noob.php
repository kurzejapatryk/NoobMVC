<?php
if (PHP_SAPI == "cli") {

    // check PHP Version
    if(phpversion()<'7.4' ){
        echo 'Your version of PHP is '.phpversion().'. Required min. 7.4';
        exit;
    }

    $short_options = "vhi::d";
    $long_options = ["version", "help", "init::", "testdb", "debug"];
    $options = getopt($short_options, $long_options);

    if(isset($options["debug"]) || isset($options["d"])) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        echo "\e[104mDebug mode is enabled!!\e[39m \n";
    }else{
        error_reporting(0);
        ini_set('display_errors', 0);
    }

    if(isset($options["testdb"])) {
        $DB_TEST = true;
        echo "\e[104mTest database is enabled!! \e[39m \n";
    }

    require_once __DIR__ . '/bootstrap.php';

    if(isset($options["v"]) || isset($options["version"])) {
        echo asciArt();
        echo appInfo();
        exit;
    }
    elseif(isset($options["h"]) || isset($options["help"])) {
        echo asciArt();
        echo "+-------------------------------------------------------------+\n"
            ."| Usage guide for NoobMCV CLI tool                            |\n"
            ."+-------------------------------------------------------------+\n"
            ."| Standard options:                                           |\n"
            ."| ----------------------------------------------------------- |\n"
            ."|  [-h] --help       | Show helps                             |\n"
            ."|  [-v] --version    | Show app and core details              |\n"
            ."|  [-i] --init       | Create all tables in database          |\n"
            ."|  [-iPASSWORD]      | Create admin user with password        |\n"
            ."|                                                             |\n"
            ."| Tests options:                                              |\n"
            ."| ------------------------------------------------------------|\n"
            ."|     --testdb       | Run test configuration for CI service  |\n"
            ."|                                                             |\n"
            ."+-------------------------------------------------------------+\n"
            ."| Examples:                                                   |\n"
            ."| ----------------------------------------------------------- |\n"
            ."|  php noob.php -h                                            |\n"
            ."|  php noob.php --help                                        |\n"
            ."|  php noob.php -ipassword123456                              |\n"
            ."|  php noob.php --init=password123456                         |\n"
            ."+-------------------------------------------------------------+\n"
            ."| NoobMCV v.".CORE_VERSION."                                  |\n"
            ."+-------------------------------------------------------------+\n";
        exit;
    }
    elseif(isset($options["i"]) || isset($options["init"])){
        $created_errors = false;
        $count_all = 0;
        $count_success = 0;
        $models = scandir('Models/');
        echo "Creating tables in database...\n\n";
        foreach ($models as $model) {
            if($model != '.' && $model != '..' && $model != 'Model.class.php' && $model != 'index.php'){
                $model = str_replace('.class.php','',$model);
                $model = 'Models\\'.$model;
                echo $model . ": ";
                $resp = $model::createTable();
                if($resp){
                    echo "\e[32mok\e[39m\n";
                    $count_all++;
                    $count_success++;
                }else{
                    if(strpos($GLOBALS['SQL_DEBUG_ARRAY'][count($GLOBALS['SQL_DEBUG_ARRAY'])-1]['error'], 'already exists')){
                        echo "\e[93mAlready exists\e[39m\n";
                    }else{
                        echo "\e[91mfail\e[39m\n";
                        $count_all++;
                        $created_errors = true;
                    }
                } 
            }
        }
        // get all Models in Plugins
        $plugins = scandir('Plugins/');
        foreach ($plugins as $plugin) {
            if($plugin != '.' && $plugin != '..' && $plugin != 'index.php' && !strpos($plugin, '.')){
                $models = scandir('Plugins/' . $plugin.'/Models/');
                $plugin = 'Plugins\\'.$plugin;
                foreach ($models as $model) {
                    if($model != '.' && $model != '..' && $model != 'Model.class.php' && $model != 'index.php'){
                        $model = str_replace('.class.php','',$model);
                        $model = $plugin.'\\Models\\'.$model;
                        echo $model . ": ";
                        $resp = $model::createTable();
                        if($resp){
                            echo "\e[32mok\e[39m\n";
                            $count_all++;
                            $count_success++;
                        }else{
                            if(strpos($GLOBALS['SQL_DEBUG_ARRAY'][count($GLOBALS['SQL_DEBUG_ARRAY'])-1]['error'], 'already exists')){
                                echo "\e[93mAlready exists\e[39m\n";
                            }else{
                                echo "\e[91mfail\e[39m\n";
                                $count_all++;
                                $created_errors = true;
                            }
                        } 
                    }
                }
            }
        }
        if($created_errors){
            echo "\nCreated ".$count_success."/".$count_all." tables in database. Some tables are not created.";
            // show error from $GLOBAL['SQL_DEBUG_ARRAY'][...]['error']
            echo "\n\n"
                ."\e[91mErrors:\e[39m\n";
            $i = 1;
            foreach($GLOBALS['SQL_DEBUG_ARRAY'] as $error){
                if($error['error'] != "Is ok!" && !strpos($error['error'], 'already exists')){
                    echo $i . ': ' . $error['error']."\n";
                    $i++;
                }
            }
            echo "\n\n";
        }else{
            echo "\nCreated ".$count_success."/".$count_all." tables in database.";
        }

        // Tworzenie domyślnych ustawień w bazie
        echo "\n\nCreating default settings in database...\n";
        Models\Setting::createDefaultSettings();
        
        $password = isset($options['i']) ? $options['i'] : $options['init'];
        if(strlen($password) >= 8){
            $user = new Models\User();
            $user->user_name = "admin";
            $user->name = "Administrator";
            $user->setPassword($password);
            $user->role = 1;
            $user->save();
            echo "User 'admin' is added ok! Password is ".$password.".";
        }elseif(strlen($password) < 8 && strlen($password) > 0){
            echo "Password is too short. Minimum length is 8 characters.";
        }
        else {
            echo "You haven't defined a password, user creation is skipped.";
        }

        echo "\n\n\e[32mInit is done!\e[39m\n\n";

    } else {
        echo asciArt();
        echo appInfo();
        exit;
    }

} else {
    header('Location: /');
    die();
}
