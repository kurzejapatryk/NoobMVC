<?php
namespace Core;

use Smarty;

use Core\Debuging;
use Models\Setting;

/**
 * Response class
 * Class for handling responses
 * @package Core
 */
class Response{

  private $smrt;
  private $data;

  /**
   * Constructor, sets default variables to the data field, initializes Smarty
   * @access public
   */
  public function __construct(){
    $smarty = new Smarty();
    $this->data = array(
      'version' => VERSION,
      'core_version' => CORE_VERSION,
      'api_version' => API_VERSION,
      'lang_code' => LANGUAGE,
      'language' => LANG,
      'url' => URL,
      'settings' => Setting::getAll()
    );
    if(isset($_GET['page'])){
      if(isset($_GET['action'])){
        $smarty->assign('active_page', $_GET['page']."/".$_GET['action']);
      }else{
              $smarty->assign('active_page', $_GET['page']);
      }
    }else{
      $smarty->assign('active_page', "");
    }

    $smarty->setTemplateDir( PATH . 'Views' );
    $smarty->setCompileDir( TMP . 'templates_c' );
    $smarty->setCacheDir(TMP . 'cache');
    $smarty->setConfigDir(PATH . 'Views/configs');

    $this->smrt = $smarty;
  }

  /**
   * Adds variables to the view template
   * @param string $name Variable name in the view template
   * @param string $value Variable value in the view template
   * @access public
   */
  public function assign(string $name, string $value) : void
  {
    $this->data[$name] = $value;
  }

  /**
   * Returns the data array
   * @return array
   */
  public function getData() : array
  {
    return $this->data;
  }

  /**
   * Displays the view template
   * @param string $view View file
   * @access public
   */
  public function displayPage(string $view) : void
  {
    if(SQL_DEBUG){
      $this->data['SQL_DEBUG_HTML'] = Debuging::getSQLDebugHTML();
    }else{
      $this->data['SQL_DEBUG_HTML'] = "";
    }
    if(is_array($this->data)){
      foreach($this->data as $key => $value){
        $this->smrt->assign($key, $value);
      }
    }
    $this->smrt->display(PATH . 'Views/' . $view);
  }

  /**
   * Returns the view template as an HTML string
   * @param string $view View file
   * @return string HTML
   */
  public function getPage(string $view) : string
  {
    if(SQL_DEBUG){
      $this->data['SQL_DEBUG_HTML'] = Debuging::getSQLDebugHTML();
    }else{
      $this->data['SQL_DEBUG_HTML'] = "";
    }
    if(is_array($this->data)){
      foreach($this->data as $key => $value){
        $this->smrt->assign($key, $value);
      }
    }

    return $this->smrt->fetch(PATH . 'Views/' . $view);
  }

  /**
   * Redirects to the specified location
   * @param string $location Location to redirect to
   * @access public
   */
  public static function redirect(string $location) : void
  {
    header('Location: '.$location);
  }

}
