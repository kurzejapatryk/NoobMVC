<?php
/************************************************|
|* Description | Main Controller                *|
|************************************************/
namespace Controllers;

use Core\Response;

/**
 * Class Home
 * Main page controller
 * @package Controllers
 * @access public
 */
class Home{

  /**
   * Start function
   * Function displays the main page
   * @return void
   * @access public
   */
  public static function start() : void
  {
    $Response = new Response();
    $Response->displayPage("Hello.tpl");
  }

}
