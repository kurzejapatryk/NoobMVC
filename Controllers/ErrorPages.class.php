<?php
namespace Controllers;

use Core\Response;

class ErrorPages{

  public static function start(){
    $resp = new Response();
    $resp->assign("ecode", "404");
    $resp->displayPage('Core/err.tpl');
  }

  public static function e404(){
    $resp = new Response();
    $resp->assign("ecode", "404");
    $resp->displayPage('Core/err.tpl');
  }


  public static function e500(){
    $resp = new Response();
    $resp->assign("ecode", "500");
    $resp->displayPage('Core/err.tpl');
  }
}
