<?php
/************************************************|
|* Description | Konfiguracja bazydanych        *|
|************************************************/

define('DB_type', 'MySQL');                  // Tymczasowowo tylko MySQL, integracja innych baz później.

/* MySQL Config */
define('DB_HOST', 'localhost');              // Host bazy danych
define('DB_PORT', '3306');                   // Port bazy danych
define('DB_USER', 'root');                   // Nazwa użytkownika bazy danych
define('DB_PASSWORD', '');                   // Hasło bazy danych
define('DB_DATABASE', 'you_database_name');  // Nazwa bazy danych
define('DB_DATETIME_FORMAT', 'Y-m-d H:i:s');
