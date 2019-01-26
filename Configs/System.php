<?php
/************************************************|
|* Author      | Patryk Kurzeja                 *|
|* Date        | 13-01-2019                     *|
|* email       | p.kurzeja@spheresystems.pl     *|
|* Project     | SphereFramefork                *|
|* Description | Konfiguracja systemowych       *|
|************************************************/

/* System */
define('URL', 'localhost');                     // Adres URL pod którym system jest dostępny
define('PATH', '');                             // Ścieżka do systemu / Zależna od ustawień serwera! / default: dirname($_SERVER['PHP_SELF']).'/')
define('TMP', PATH . '/tmp/');                  // Scieżka do kataalogu plików tymczasowych
define('VERSION', '1.0.0');                     // Wersja oprogramowania


/* Core Constants */
define('CORE_VERSION', '1.0.0');                // Wersja Frameworka
