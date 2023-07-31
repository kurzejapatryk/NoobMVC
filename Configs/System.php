<?php
/************************************************|
|* Description | Konfiguracja systemowych       *|
|************************************************/

/* System */
define('URL', '/');     // Adres URL pod którym system jest dostępny
define('PATH', '');                                 // Ścieżka do systemu / Zależna od ustawień serwera! / default: dirname($_SERVER['PHP_SELF']).'/')
define('TMP', PATH . '/tmp/');                      // Scieżka do kataalogu plików tymczasowych
define('VERSION', '1.0.0');                         // Wersja oprogramowania
define('API_VERSION', '1.0.0');                     // Wersja API

define('SESSION_EXPIRED_TIME', 3600);               // Czas wygaśnięcia sesji logowania
define('SALT', 'pPWTDU8M9bHntDfURxVE2eEAj4rXhtHB');

/* Core Constants */
define('CORE_VERSION', '1.0.0');                    // Wersja Frameworka
