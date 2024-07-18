<?php
/************************************************|
|* Beschreibung | Sprachdatei - DEUTSCH         *|
|************************************************/

    /* Allgemein */
 define('LANG', array(
    "username_or_password_is_invalid" => "Dein Benutzername oder Passwort ist ungültig.",
    "login_btn" => "Anmelden",

    // Hello.tpl
    "hello" => "Hallo Welt!",
    "hello_installation_successful" => "NoobMVC Installation erfolgreich!",
    "hello_message" => 
            "<p class='p-2'>Dies ist die Standardansicht für den Hello-Controller. Sie finden sie in der Datei Views/Hello.tpl.
            Weitere Informationen zur Verwendung von NoobMVC finden Sie auf der <a href='https://github.com/kurzejapatryk/NoobMVC/wiki'>NoobMVC-Website auf Github</a>.</p>
            <p>Jetzt können Sie Ihre eigenen Controller und Ansichten erstellen!</p>",


    /* Monate */
    "months" => [
        '01' => "Januar",
        '02' => "Februar",
        '03' => "März",
        '04' => "April",
        '05' => "Mai",
        '06' => "Juni",
        '07' => "Juli",
        '08' => "August",
        '09' => "September",
        '10' => "Oktober",
        '11' => "November",
        '12' => "Dezember",
        /* Kurze Monate */
        "Jan" => "JAN",
        "Feb" => "FEB",
        "Mar" => "MÄR",
        "Apr" => "APR",
        "May" => "MAI",
        "Jun" => "JUN",
        "Jul" => "JUL",
        "Aug" => "AUG",
        "Sep" => "SEP",
        "Oct" => "OKT",
        "Nov" => "NOV",
        "Dec" => "DEZ",
    ],


    /* Validierungsfehler */
    "val_errors" => [
        "val_pattern" => "Ungültiges Datenformat.",
        "val_required" => "Dieses Feld ist erforderlich.",
        "val_min" => "Der Wert ist zu klein.",
        "val_max" => "Der Wert ist zu groß.",
        "val_equal" => "Der Wert sollte gleich sein wie ",
        "val_file_max_size" => "Die Datei ist zu groß.",
        "val_file_ext" => "Ungültiges Dateiformat.",
    ],

    /* Fehlerseiten */
    "404" => "Diese Seite existiert nicht",
    "500" => "Interner Serverfehler"

));
