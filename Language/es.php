<?php
/************************************************|
|* Descripción | Archivo de idioma - ESPAÑOL     *|
|************************************************/

    /* General */
 define('LANG', array(
    "username_or_password_is_invalid" => "Tu nombre de usuario o contraseña es inválido.",
    "login_btn" => "Iniciar sesión",
    
    // Hello.tpl
    "hello" => "¡Hola Mundo!",
    "hello_installation_successful" => "¡Instalación exitosa de NoobMVC!",
    "hello_message" => 
            "<p class='p-2'>Esta es la vista predeterminada para el controlador Hello. Puedes encontrarla en el archivo Views/Hello.tpl.
            Para obtener más información sobre cómo usar NoobMVC, visita el <a href='https://github.com/kurzejapatryk/NoobMVC/wiki'>sitio web de NoobMVC en Github</a>.</p>
            <p>¡Ahora crea tus propios controladores y vistas!</p>",
    
    /* Months */
    "months" => [
        '01' => "Enero",
        '02' => "Febrero",
        '03' => "Marzo",
        '04' => "Abril",
        '05' => "Mayo",
        '06' => "Junio",
        '07' => "Julio",
        '08' => "Agosto",
        '09' => "Septiembre",
        '10' => "Octubre",
        '11' => "Noviembre",
        '12' => "Diciembre",
        /* Short months */
        "Jan" => "ENE",
        "Feb" => "FEB",
        "Mar" => "MAR",
        "Apr" => "ABR",
        "May" => "MAY",
        "Jun" => "JUN",
        "Jul" => "JUL",
        "Aug" => "AGO",
        "Sep" => "SEP",
        "Oct" => "OCT",
        "Nov" => "NOV",
        "Dec" => "DIC",
    ],


    /* Validation errors */
    "val_errors" => [
        "val_pattern" => "Formato de datos inválido.",
        "val_required" => "Este campo es obligatorio.",
        "val_min" => "El valor es demasiado pequeño.",
        "val_max" => "El valor es demasiado grande.",
        "val_equal" => "El valor debe ser igual a ",
        "val_file_max_size" => "El archivo es demasiado grande.",
        "val_file_ext" => "Formato de archivo inválido.",
    ],

    /* Error pages */
    "404" => "Esta página no existe",
    "500" => "Error interno del servidor"

));
