<?php
    // load configs
    $conf_dir = "Configs/";
    $dir = scandir($conf_dir);
    foreach ($dir as $check_dir){
    if(is_file($conf_dir . $check_dir))
        require_once __DIR__ . '/'.$conf_dir . $check_dir;
    }
    
    // Test database
    if(isset($_SERVER['CI']) || isset($_SERVER["DOCKER"]) || isset($_SERVER['SERVER_ADDR']) && str_contains($_SERVER['SERVER_ADDR'], '172.') ||isset($GLOBALS['DB_TEST'])){
        $DB_CONF = [
            'HOST' => 'mysql',
            'PORT' => '3306',            
            'USER' => 'db_user',            
            'PASSWORD' => 'password123',      
            'DATABASE' => 'test_db',           
            'DATETIME_FORMAT' => 'Y-m-d H:i:s'   
        ];
    }

    define('DB_HOST', $DB_CONF['HOST']);                    
    define('DB_PORT', $DB_CONF['PORT']);                    
    define('DB_USER', $DB_CONF['USER']);                    
    define('DB_PASSWORD', $DB_CONF['PASSWORD']);            
    define('DB_DATABASE', $DB_CONF['DATABASE']);            
    define('DB_DATETIME_FORMAT', $DB_CONF['DATETIME_FORMAT']);

    unset($GLOBALS['DB_CONF']);

    // load language
    $userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $acceptLang = [];
    $langs = scandir('Language/');
    foreach ($langs as $lang) {
        if($lang != '.' && $lang != '..' && $lang != 'index.php'){
            $acceptLang[] = str_replace('.php','',$lang);
        }
    }
    $lang = in_array($userLang, $acceptLang) ? $userLang : DEFAULT_LANGUAGE;
    define('LANGUAGE', $lang);

    // load classes
    spl_autoload_register(function ($name){
        $className = (string) str_replace('\\', DIRECTORY_SEPARATOR, $name);
        require_once __DIR__ . '/' . $className.'.class.php';
        return true;
    });