<?php
/************************************************|
|* Description | Database Configuration          *|
|************************************************/

define('DB_type', 'MySQL');                     // Temporary only MySQL, integration of other databases later.

$DB_CONF = [
    'HOST' => 'localhost',                      // Database host
    'PORT' => '3306',                           // Database port
    'USER' => 'root',                           // Database username
    'PASSWORD' => '',                           // Database password
    'DATABASE' => 'test_db',                    // Database name
    'DATETIME_FORMAT' => 'Y-m-d H:i:s'          // Date format in the database
];
