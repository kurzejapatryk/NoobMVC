<?php
/************************************************|
|* Description | Response class                  *|
|************************************************/

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
   * @author Patryk Kurzeja <patrykkurzeja@proton.me>
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function __construct(){
    $smarty = new Smarty();
    $this->data = array(
      'version' => VERSION,
      'core_version' => CORE_VERSION,
      'api_version' => API_VERSION,
      'language' => LANGUAGE,
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
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function assign($name, $value){
    $this->data[$name] = $value;
  }

  /**
   * Returns the data array
   * @return array
   */
  public function getData(){
    return $this->data;
  }

  /**
   * Displays the view template
   * @param string $view View file
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function displayPage($view){
    $this->assign('lang', LANG);
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
  public function getPage($view){
    $this->assign('lang', LANG);
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
   * Generates a JSON response
   * @param bool $get Whether to return the JSON string or echo it
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function getJSON($get = false){
    if(SQL_DEBUG){
      $this->data['SQL_DEBUG_ARRAY'] = $GLOBALS['SQL_DEBUG_ARRAY'];
    }
    
    if($get){
      return json_encode($this->data);
    }else{
      header('Content-Type: application/json');
      echo json_encode($this->data);
    }

  }

  public static function redirect($location){
    header('Location: '.$location);
  }

}
