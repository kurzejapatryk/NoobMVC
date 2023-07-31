<?php
/************************************************|
|* Description | Kontroler startowy             *|
|************************************************/
namespace Controllers;

use Core\Response;

class Home{

  public static function start(){
    $resp = new Response();
    $resp->assign('lang', LANG);
    $resp->displayPage('Hello.tpl');
  }

}
