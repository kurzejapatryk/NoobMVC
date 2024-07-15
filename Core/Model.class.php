<?php
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
   * @access public
   */
  public function __construct(int $id = null)
  {
    if(!is_null($id)){
      $this->id = (int)$id;
      $this->get();
    }
  }

  /**
   * Returns the table name in the database
   * @return string returns the table name
   * @access public
   */
  public static function getTableName() : string
  {
    $table_name = static::$table;
    return $table_name;
  }

  /**
   * Returns the table schema in the database
   * @return array returns the table schema
   * @access public
   */
  public static function getTableSchema() : array
  {
    $table_schema = static::$schema;
    return $table_schema;
  }

  /**
   * Checks if the object variable exists
   * @param string $name variable name
   * @return boolean returns true if the variable exists
   * @access public
   */
  public function __isset(string $name) : bool
  {
    return isset($this->{$name});
  }

  /**
   * Unsets the object variable
   * @param string $name variable name
   * @access public
   */
  public function __unset(string $name) : void
  {
    unset($this->{$name});
  }

  /**
   * Resets the object to its initial state
   * @access public
   */
  public function reset() : void
  {
    $vars = get_object_vars($this);
    foreach($vars as $key => $val){
      if($key != 'table' && $key != 'schema')
      $this->{$key} = null;
    }
  }

  /**
   * Returns the object id
   * @return integer object identifier
   * @access public
   */
  public function getId() : int
  {
    return $this->id;
  }

  /**
   * Saves the object changes to the database
   * @return object returns the object
   * @access public
   */
  public function save() : self
  {
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
   * @access public
   */
  public function delete() : void
  {
    $vars = get_object_vars($this);
    $id = $vars['id'];
    $table = static::$table;
    unset($vars['table']);
    unset($vars['id']);
    Db::delete('DELETE FROM '.$table.' WHERE id = ?',array($id));
  }

  /**
   * Retrieves the object from the database
   * @return object returns the retrieved object
   * @access public
   */
  public function get() : self
  {
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
   * @return object|null returns the retrieved object
   * @access public
   */
  public function find() : self|null
  {
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
   * @access public
   */
  public static function getAll(array $where = array(), string $order = "id ASC") : array
  {
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
   * @return bool returns true if the table was created
   * @access public
   */
  public static function createTable() : bool
  {
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
   * @return int|false returns the result of the operation
   * @access public
   */
  public static function dropTable() : int|false
  {
    $SQL = "DROP TABLE " . static::$table;
    $result = Db::delete($SQL);
    return $result;
  }
}
