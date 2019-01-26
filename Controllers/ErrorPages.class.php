<?php
namespace Controllers;

use Core\Response;

class ErrorPages{

  public static function start(){
    $resp = new Response();
    $resp->displayPage('ErrorPages/404.tpl');
  }

  public static function e404(){
    $resp = new Response();
    $resp->displayPage('ErrorPages/404.tpl');
  }


  public static function e500(){
    $resp = new Response();
    $resp->displayPage('ErrorPages/500.tpl');
  }
}
