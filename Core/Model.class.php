<?php
/************************************************|
|* Description | Szablon modelu                 *|
|************************************************/

namespace Core;

use Core\Db;

class Model{

  public static function getTableName(){
    $class = __CLASS__;
    $Object = new $class;
    $table_name = $Object->table;
    return $table_name;
  }

  /**
   * Konstruktor obiektu
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @param integer $id identyfikator obiektu
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */

  public function __construct($id = null){
    $this->id = (int)$id;
    if($id){
      $this->get();
    }
  }

  /**
   * Zwraca id obiektu
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @return integer identyfikator obiektu
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */

  public function getId(){
    return $this->id;
  }

  /**
   * Zapisuje zmiany obiektu w bazie
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @return object zwraca obiekt modelu
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function save(){

    $vars = get_object_vars($this);
    if($vars['id']){
      $id = $vars['id'];
      $opr = 'update';
    }else{
      $opr = 'add';
    }
    
    $table = $this->table;

    unset($vars['id']);
    unset($vars['table']);


    if($opr == 'update'){
      $values = array();
      $columns = "";
      $first = true;

      foreach($vars as $key => $var){
        if(!$first){
          $columns .= ", ";
        }else{
          $first = false;
        }
        $columns .= $key . " = ?";
        $values[] = $var;
      }

      $SQL = "UPDATE ".$table." SET ".$columns." WHERE id = ".$id;
      Db::update($SQL, $values);

    }elseif($opr == 'add'){
      $values = array();
      $columns = "";
      $first = true;
      $itr = "";

      foreach($vars as $key => $var){
        if(!$first){
          $columns .= ", ";
          $itr .= ", ";
        }else{
          $first = false;
        }
        $columns .= $key;
        $values[] = $var;
        $itr .= "?";

      }

      $SQL = "INSERT INTO ".$table." (".$columns.") VALUES (".$itr.")";
      $id = Db::insert($SQL, $values);
      $this->id = $id;
    }

    return $this;
  }


  /**
   * Usuwa obiekt z bazy
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function del(){
    $vars = get_object_vars($this);
    $id = $vars['id'];
    $table = $this->table;
    unset($vars['table']);
    unset($vars['id']);
    Db::delete('DELETE FROM '.$table.' WHERE id = ?',array($id));
    return null;
  }

  /**
   * Pobiera obiekt z bazy
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @return object zwraca pobrany obiekt
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function get(){
    $id = $this->id;
    $table = $this->table;
    if($id){
      $SQL = "SELECT * FROM ".$table." WHERE id = ? LIMIT 1";
      $params = Db::select($SQL, array($id), true);
      foreach($params as $key => $val){
        $this->{$key} = $val;
      }
    }
    return $this;
  }

  /**
   * Wyszukuje i pobiera obiekt z bazy
   * @author Patryk Kurzeja <patrykkurzeja.go@gmail.com>
   * @return object zwraca pobrany obiekt
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */

  public function search(){
    $vars = get_object_vars($this);
    $table = $this->table;

    $columns = "";
    $where_vars = array();
    $first = true;

    unset($vars['table']);
    unset($vars['id']);
    
    foreach($vars as $key => $var){
      if($var){
        if(!$first){
          $columns .= ", ";
        }else{
          $fisrt = false;
        }

        $columns .= $key . " = ?";
        $where_vars[] = $var;
      }
    }

    if(count($where_vars)){
      $SQL = "SELECT * FROM ".$table." WHERE ".$columns." LIMIT 1";
      $params = Db::select($SQL, $where_vars, true);
      if(!empty($params)){
        foreach($params as $key => $val){
          $this->{$key} = $val;
        }
      }
      return $this;
    }else{
      return null;
    }
  }

  public function getAll($where = array()){
    $table = $this->table;
    $className =  __CLASS__;
    $data = array();
    $SQL = "SELECT * FROM ".$table;

    if(is_array($where)){
      if(!empty($where)){
        $where_SQL = " WHERE ";
        $i = 0;

        foreach($where as $column => $val){
          if($i != 0) $where_SQL .= ' AND ';
          $where_SQL .= $column . " = ?";
          $data[] = $val;
        }
        $SQL .= $where_SQL;
      }

      $resp = Db::select($SQL, $data);

      if(is_array($resp)){
        $resp_data = array();
        foreach($resp as $row){
          $Obj = new $className();
          foreach($row as $key => $val){
            $Obj->{$key} = $val;
          }
          $resp_data[$Obj->id] = $Obj;
        }
        return $resp_data;
      }else{
        return array();
      }

    }else{
      throw new Exception("First parametr of function BlogPost->getAll must be array()!");
    }
  }
}
