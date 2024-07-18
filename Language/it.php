<?php
/************************************************|
|* Descrizione | File di lingua - ITALIANO       *|
|************************************************/

    /* Generale */
 define('LANG', array(
    "username_or_password_is_invalid" => "Il tuo nome utente o password non è valido.",
    "login_btn" => "Accedi",

    // Hello.tpl
    "hello" => "Ciao Mondo!",
    "hello_installation_successful" => "Installazione di NoobMVC riuscita!",
    "hello_message" => 
            "<p>Questa è la vista predefinita per il controller Hello. Puoi trovarla nel file Views/Hello.tpl.
            Per ulteriori informazioni su come utilizzare NoobMVC, visita il <a href='https://github.com/kurzejapatryk/NoobMVC/wiki'>sito web di NoobMVC su Github</a>.</p>
            <p>Ora puoi creare i tuoi controller e viste personalizzate!</p>",
    
    /* Mesi */
    "months" => [
        '01' => "Gennaio",
        '02' => "Febbraio",
        '03' => "Marzo",
        '04' => "Aprile",
        '05' => "Maggio",
        '06' => "Giugno",
        '07' => "Luglio",
        '08' => "Agosto",
        '09' => "Settembre",
        '10' => "Ottobre",
        '11' => "Novembre",
        '12' => "Dicembre",
        /* Mesi abbreviati */
        "Jan" => "GEN",
        "Feb" => "FEB",
        "Mar" => "MAR",
        "Apr" => "APR",
        "May" => "MAG",
        "Jun" => "GIU",
        "Jul" => "LUG",
        "Aug" => "AGO",
        "Sep" => "SET",
        "Oct" => "OTT",
        "Nov" => "NOV",
        "Dec" => "DIC",
    ],


    /* Errori di validazione */
    "val_errors" => [
        "val_pattern" => "Formato dati non valido.",
        "val_required" => "Questo campo è obbligatorio.",
        "val_min" => "Il valore è troppo piccolo.",
        "val_max" => "Il valore è troppo grande.",
        "val_equal" => "Il valore dovrebbe essere uguale a ",
        "val_file_max_size" => "Il file è troppo grande.",
        "val_file_ext" => "Formato file non valido.",
    ],

    /* Pagine di errore */
    "404" => "Questa pagina non esiste",
    "500" => "Errore interno del server"

));
