<?php
namespace Controllers;

use Core\Response;

/**
 * Class ErrorPages
 * Error Pages Controller
 * @package Controllers
 */
class ErrorPages{

  /**
   * start function
   * Function redirects to the main page
   * @return void
   * @access public
   */
  public static function start() : void
  {
    header("Location: /");
    exit;
  }


  /**
   * e404 function
   * Function displays the 404 error page - not found
   * @return void
   * @access public
   */
  public static function e404() : void
  {
    $resp = new Response();
    $resp->assign("ecode", "404");
    $resp->displayPage('Core/err.tpl');
  }

  /**
   * e500 function
   * Function displays the 500 error page - internal server error
   * @return void
   * @access public
   */
  public static function e500() : void
  {
    $resp = new Response();
    $resp->assign("ecode", "500");
    $resp->displayPage('Core/err.tpl');
  }

  /**
   * e403 function
   * Function displays the 403 error page - access denied
   * @return void
   * @access public
   */
  public static function e403() : void
  {
    $resp = new Response();
    $resp->assign("ecode", "403");
    $resp->displayPage('Core/err.tpl');
  }

  /**
   * e401 function
   * Function displays the 401 error page - unauthorized
   * @return void
   * @access public
   */
  public static function e401() : void
  {
    $resp = new Response();
    $resp->assign("ecode", "401");
    $resp->displayPage('Core/err.tpl');
  }

  /**
   * e400 function
   * Function displays the 400 error page - bad request
   * @return void
   * @access public
   */
  public static function e400() : void
  {
    $resp = new Response();
    $resp->assign("ecode", "400");
    $resp->displayPage('Core/err.tpl');
  }
}
