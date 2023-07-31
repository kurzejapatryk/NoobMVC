<?php
/************************************************|
|* Description | Klasa odpowiedzi               *|
|************************************************/

namespace Core;

use Smarty;

use Core\Debuging;

class Response{

  private $smrt;
  private $data;

  /**
   * Konstruktor, wpisuje standardowe zmienne do pola data, ustawia smarty
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function __construct(){
    $smarty = new Smarty();
    $this->data = array(
      'version' => VERSION,
      'language' => LANGUAGE,
      'url' => URL,
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
   * Dodaje zmienne do widoku
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @param string $name Nazwa zmiennej w widoku
   * @param string $value Wartość zmiennje w widoku
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function assign($name, $value){
    $this->data[$name] = $value;
  }

  /**
   * Wyświetla widok
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @param string $view plik widoku
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
   * Generuje odpowiedź JSON
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function getJSON(){
    header('Content-Type: application/json');
    echo json_encode($this->data);
  }

  public function redirect($location){
    header('Location: '.$location);
  }

}
