<?php
/************************************************|
|* Description | System Configuration           *|
|************************************************/

/* System */
define('APP_NAME', 'NoobMVC');                      // Application name
define('URL', 'http://localhost');                  // URL address where the system is accessible
define('PATH', '');                                 // System path / Depends on server settings! / default: dirname($_SERVER['PHP_SELF']).'/')
define('TMP', PATH . 'tmp/');                       // Path to the temporary files directory
define('VERSION', '1.0.0');                         // Software version
define('API_VERSION', '1.0.0');                     // API version

define('SESSION_EXPIRED_TIME', 3600);               // Login session expiration time
define('SALT', 'pPWDrfft45M9bHntDdRf4E2eEA46rXht'); // Salt used for password hashing

/* Core Constants */
define('CORE_VERSION', '1.2.4');                    // Framework version
