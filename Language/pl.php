<?php
/************************************************|
|* Description | Plik językowy - POLSKI         *|
|************************************************/

/* General */
 define('LANG', array(
  "username_or_password_is_invalid" => "Błędny login lub hasło.",
  "login_btn" => "Zaloguj",

    // Hello.tpl
    "hello" => "Witaj świecie!",
    "hello_installation_successful" => "Instalacja NoobMVC zakończona sukcesem!",
    "hello_message" => 
            "<p class='my-2'>To jest domyślny widok dla kontrolera Hello. Możesz go znaleźć w pliku Views/Hello.tpl.
            Aby uzyskać więcej informacji na temat korzystania z NoobMVC, odwiedź <a href='https://github.com/kurzejapatryk/NoobMVC/wiki'>stronę NoobMVC na Githubie</a>.</p>
            <p>Teraz stwórz własne kontrolery i widoki!</p>",

  /* Months */
  "months" => [
    '01' => "Styczeń",
    '02' => "Luty",
    '03' => "Marzec",
    '04' => "Kwiecień",
    '05' => "Maj",
    '06' => "Czerwiec",
    '07' => "Lipiec",
    '08' => "Sierpień",
    '09' => "Wrzesień",
    '10' => "Październik",
    '11' => "Listopad",
    '12' => "Grudzień",
    /* Short months */
    "Jan" => "STY",
    "Feb" => "LUT",
    "Mar" => "MAR",
    "Apr" => "KWI",
    "May" => "MAJ",
    "Jun" => "CZE",
    "Jul" => "LIP",
    "Aug" => "SIE",
    "Sep" => "WRZ",
    "Oct" => "PAŹ",
    "Nov" => "LIS",
    "Dec" => "GRU",
  ],

  /* Validation errors */
  "val_errors" => [
    "val_pattern" => "Niepoprawny format danych.",
    "val_required" => "Pole jest wymagane.",
    "val_min" => "Wartość jest zbyt mała.",
    "val_max" => "Wartość jest zbyt duża.",
    "val_equal" => "Wartość powinna być równa ",
    "val_file_max_size" => "Plik jest zbyt duży.",
    "val_file_ext" => "Niedozwolony format pliku.",
  ],

  /* Error pages */
  "404" => "Strona nie istnieje",
  "500" => "Wystąpił błąd serwera"


));
