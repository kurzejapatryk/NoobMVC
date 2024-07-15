<?php
/************************************************|
|* Description | Model template                 *|
|************************************************/

namespace Core;

use Exception;
use Core\Db;

/**
 * Model Class
 * Model template
 * @package Core
 */
class Model{

  public $id;
  protected static $table;
  protected static $schema;

  /**
   * Object constructor
   * @param integer $id object identifier
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function __construct($id = null){
    if(!is_null($id)){
      $this->id = (int)$id;
      $this->get();
    }
  }

  /**
   * Returns the table name in the database
   * @return string returns the table name
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function getTableName(){
    $table_name = static::$table;
    return $table_name;
  }

  /**
   * Returns the table schema in the database
   * @return array returns the table schema
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function getTableSchema(){
    $table_schema = static::$schema;
    return $table_schema;
  }

  /**
   * Checks if the object variable exists
   * @param string $name variable name
   * @return boolean returns true if the variable exists
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function __isset($name){
    return isset($this->{$name});
  }

  /**
   * Unsets the object variable
   * @param string $name variable name
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function __unset($name){
    unset($this->{$name});
  }

  /**
   * Resets the object to its initial state
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function reset(){
    $vars = get_object_vars($this);
    foreach($vars as $key => $val){
      if($key != 'table' && $key != 'schema')
      $this->{$key} = null;
    }
  }

  /**
   * Returns the object id
   * @return integer object identifier
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function getId(){
    return $this->id;
  }

  /**
   * Saves the object changes to the database
   * @return object returns the model object
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function save(){

    $vars = get_object_vars($this);
    if(isset($vars['id'])){
      $id = $vars['id'];
      $opr = 'update';
    }else{
      $opr = 'add';
    }
    
    $table = static::$table;

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
   * Deletes the object from the database
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function delete(){
    $vars = get_object_vars($this);
    $id = $vars['id'];
    $table = static::$table;
    unset($vars['table']);
    unset($vars['id']);
    Db::delete('DELETE FROM '.$table.' WHERE id = ?',array($id));
    return null;
  }

  /**
   * Retrieves the object from the database
   * @return object returns the retrieved object
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function get(){
    $table = static::$table;
    if(!is_null($this->id)){
      $id = $this->id;
      $SQL = "SELECT * FROM ".$table." WHERE id = ? LIMIT 1";
      $params = Db::select($SQL, array($id), true);
      if(is_array($params)){
        foreach($params as $key => $val){
          $this->{$key} = $val;
        }
      }
    }
    return $this;
  }

  /**
   * Searches and retrieves the object from the database
   * @return object returns the retrieved object
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public function find(){
    $vars = get_object_vars($this);
    $table = static::$table;

    $columns = "";
    $where_vars = array();
    $first = true;

    unset($vars['table']);
    unset($vars['schema']);
    unset($vars['id']);
    
    foreach($vars as $key => $var){
      if($var != null){
        if(!$first){
          $columns .= " AND ";
        }else{
          $first = false;
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

  /**
   * Retrieves all objects from the database
   * @param array $where search conditions
   * @param string $order sorting order
   * @return array returns an array of objects
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function getAll($where = array(), $order = "id ASC"){
    $table = static::$table;
    $className =  get_called_class();
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

      $SQL .= " ORDER BY ".$order;
      
      $resp = Db::select($SQL, $data);

      if(is_array($resp)){
        $resp_data = array();
        foreach($resp as $row){
          $Obj = new $className();
          $row = is_array($row) ? $row : array();
          foreach($row as $key => $val){
            if(!is_numeric($key)){
              $Obj->{$key} = $val;
            }
          }
          $resp_data[$Obj->id] = $Obj;
        }
        return $resp_data;
      }else{
        return array();
      }

    }else{
      throw new Exception("First parameter of function Model->getAll must be array()!");
    }
  }

  /**
   * Creates a table in the database
   * @return string returns the SQL query
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function createTable(){
    $SQL = "CREATE TABLE " . static::$table . " ( ";
    $coma = false;
    foreach(static::$schema as $key => $val){
      if($coma){
        $SQL .= ", ";
      }
      else {
        $coma = true;
      }
      $SQL .= $key . " " . $val;
    }
    $SQL .= " )";
    $result = Db::create($SQL);
    return $result;
  }

  /**
   * Drops a table from the database
   * @return string returns the SQL query
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function dropTable(){
    $SQL = "DROP TABLE " . static::$table;
    $result = Db::delete($SQL);
    return $result;
  }
}
