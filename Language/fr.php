<?php
/************************************************|
|* Description | Fichier de langue - Français   *|
|************************************************/

    /* Général */
 define('LANG', array(
    "username_or_password_is_invalid" => "Votre nom d'utilisateur ou votre mot de passe est invalide.",
    "login_btn" => "Connexion",

    // Hello.tpl
    "hello" => "Bonjour le monde !",
    "hello_installation_successful" => "Installation réussie de NoobMVC !",
    "hello_message" => 
            "<p>Ceci est la vue par défaut pour le contrôleur Hello. Vous pouvez le trouver dans le fichier Views/Hello.tpl.
            Pour plus d'informations sur l'utilisation de NoobMVC, veuillez visiter le <a href='https://github.com/kurzejapatryk/NoobMVC/wiki'>site web de NoobMVC sur Github</a>.</p>
            <p>Maintenant, créez vos propres contrôleurs et vues !</p>",
    
    /* Mois */
    "months" => [
        '01' => "Janvier",
        '02' => "Février",
        '03' => "Mars",
        '04' => "Avril",
        '05' => "Mai",
        '06' => "Juin",
        '07' => "Juillet",
        '08' => "Août",
        '09' => "Septembre",
        '10' => "Octobre",
        '11' => "Novembre",
        '12' => "Décembre",
        /* Mois abrégés */
        "Jan" => "JAN",
        "Feb" => "FEV",
        "Mar" => "MAR",
        "Apr" => "AVR",
        "May" => "MAI",
        "Jun" => "JUI",
        "Jul" => "JUI",
        "Aug" => "AOU",
        "Sep" => "SEP",
        "Oct" => "OCT",
        "Nov" => "NOV",
        "Dec" => "DEC",
    ],


    /* Erreurs de validation */
    "val_errors" => [
        "val_pattern" => "Format de données invalide.",
        "val_required" => "Ce champ est requis.",
        "val_min" => "La valeur est trop petite.",
        "val_max" => "La valeur est trop grande.",
        "val_equal" => "La valeur doit être égale à ",
        "val_file_max_size" => "Le fichier est trop volumineux.",
        "val_file_ext" => "Format de fichier invalide.",
    ],

    /* Pages d'erreur */
    "404" => "Cette page n'existe pas",
    "500" => "Erreur interne du serveur"

));
