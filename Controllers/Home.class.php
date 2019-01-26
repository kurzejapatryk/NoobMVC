<?php
/************************************************|
|* Author      | Patryk Kurzeja                 *|
|* Date        | 15-11-2017                     *|
|* email       | p.kurzeja@spheresystems.pl     *|
|* Project     | SphereFramefork                *|
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
