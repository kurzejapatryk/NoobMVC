<?php
/************************************************|
|* Descrição | Arquivo de idioma - PORTUGUÊS     *|
|************************************************/

    /* Geral */
 define('LANG', array(
    "username_or_password_is_invalid" => "Seu nome de usuário ou senha é inválido.",
    "login_btn" => "Entrar",

    // Hello.tpl
    "hello" => "Olá Mundo!",
    "hello_installation_successful" => "Instalação do NoobMVC bem-sucedida!",
    "hello_message" => 
            "<p class='p-2'>Esta é a visualização padrão para o controlador Hello. Você pode encontrá-lo no arquivo Views/Hello.tpl.
            Para obter mais informações sobre como usar o NoobMVC, visite o <a href='https://github.com/kurzejapatryk/NoobMVC/wiki'>site do NoobMVC no Github</a>.</p>
            <p>Agora, crie seus próprios controladores e visualizações!</p>",
    
    /* Meses */
    "months" => [
        '01' => "Janeiro",
        '02' => "Fevereiro",
        '03' => "Março",
        '04' => "Abril",
        '05' => "Maio",
        '06' => "Junho",
        '07' => "Julho",
        '08' => "Agosto",
        '09' => "Setembro",
        '10' => "Outubro",
        '11' => "Novembro",
        '12' => "Dezembro",
        /* Meses abreviados */
        "Jan" => "JAN",
        "Feb" => "FEV",
        "Mar" => "MAR",
        "Apr" => "ABR",
        "May" => "MAI",
        "Jun" => "JUN",
        "Jul" => "JUL",
        "Aug" => "AGO",
        "Sep" => "SET",
        "Oct" => "OUT",
        "Nov" => "NOV",
        "Dec" => "DEZ",
    ],


    /* Erros de validação */
    "val_errors" => [
        "val_pattern" => "Formato de dados inválido.",
        "val_required" => "Este campo é obrigatório.",
        "val_min" => "O valor é muito pequeno.",
        "val_max" => "O valor é muito grande.",
        "val_equal" => "O valor deve ser igual a ",
        "val_file_max_size" => "O arquivo é muito grande.",
        "val_file_ext" => "Formato de arquivo inválido.",
    ],

    /* Páginas de erro */
    "404" => "Esta página não existe",
    "500" => "Erro interno do servidor"

));
