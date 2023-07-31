<?php
/************************************************|
|* Description | Kontroler startowy             *|
|************************************************/
namespace Controllers;

use Core\Response;
use Plugins\Authentication;

class Home{

  public static function start(){
    $resp = new Response();
    $auth = new Authentication();
    $auth->log_in('admin', 'poziomC1');
    $resp->assign('lang', LANG);
    $resp->displayPage('Hello.tpl');

  }

}
