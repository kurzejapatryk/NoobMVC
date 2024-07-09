<?php
/************************************************|
|* Description | Database Configuration          *|
|************************************************/

define('DB_type', 'MySQL');                     // Temporary only MySQL, integration of other databases later.

$DB_CONF = [
    'HOST' => '127.0.0.1',                      // Database host
    'PORT' => '3306',                           // Database port
    'USER' => 'root',                           // Database username
    'PASSWORD' => '',                           // Database password
    'DATABASE' => 'test_db',                    // Database name
    'DATETIME_FORMAT' => 'Y-m-d H:i:s'          // Date format in the database
];


/* Do not change anything below this line
*************************************************
*/

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

unset($DB_CONF);
