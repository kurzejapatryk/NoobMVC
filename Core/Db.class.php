<?php
namespace Core;

use \PDO;
use \PDOException;
use PDOStatement;

/**
 * Class Db
 * Database controller
 * @package Core
 */
class Db{

  /**
   * Establishes a connection to the database
   * @return object PDO database connection
   * @access public
   */
  public static function connect() : PDO
  {
    $PDO = null;
    try{
      $PDO = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD);
      $PDO->exec("SET CHARACTER SET utf8");
    }catch (PDOException $e) {
      define('SQL_ERROR', $e);
    }
    return $PDO;
  }

  /**
   * Retrieves records from the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @param bool $assoc Whether to return an associative array
   * @return PDOStatement|array|null Records
   * @access public
   */
  public static function select(string $query, array $var = array(), bool $assoc = false) : PDOStatement|array|null
  {
    $PDO = Db::connect();
    $result = NULL;
    try{
      $qr = $PDO->prepare($query);
      if(!$qr){
         $error = $PDO->errorInfo();
      }else{
        $i=1;
        foreach($var as $value){
          $qr->bindValue($i, $value);
          $i++;
        }
        $result = $qr->execute();
        if(!$result){
           $error = $qr->errorInfo();
        }else{
          $error = array(0,0,"Is ok!");
          if($assoc){
            $result = $qr->fetch(PDO::FETCH_ASSOC);
          }else{
            $result = $qr->fetchAll();
          }
          $qr->closeCursor();
        }
        $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2], 'result' => $result);
      }
    }catch (PDOException $e){
      $PDO = null;
    }
    $PDO = null;
    return $result;
  }

  /**
   * Deletes records from the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @return bool|int Number of deleted records
   * @access public
   */
  public static function delete(string $query, array $var = array()) : int|null
  {
      $PDO = Db::connect();
      $result=0;
      try{
         $qr = $PDO->prepare($query);
         if(!$qr){
           $error = $PDO->errorInfo();
         }else{
           $i=1;
           foreach($var as $value){
                $qr->bindValue($i, $value);
                $i++;
           }
           $result = $qr->execute();
           if(!$result){
             $error = $qr->errorInfo();
           }else{
               $error = array(0,0,"Is ok!");
           }
            $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2], 'result' => $result);
           $qr->closeCursor();
         }
      }catch(PDOException $e) {
        $PDO = null;
    }
    $PDO = null;
    return $result;
  }


  /**
   * Adds a record to the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @return bool|string|null Last inserted ID
   * @access public
   */
  public static function insert(string $query, array $var = array()) : bool|string|null
  {
    $last_id = NULL;
    try{
       $PDO = Db::connect();
        $qr = $PDO->prepare($query);
        $i=1;
        if(!$qr){
          $error = $PDO->errorInfo();
        }else{
          foreach($var as $value){
            if(true_empty($value)){
              $value='';
            }
            $qr->bindValue($i, $value);
            $i++;
          }
          $resp = $qr->execute();
          if(!$resp){
            $error = $qr->errorInfo();
          }else{
            $error = array(0,0,"Is ok!");
            $qr->closeCursor();
            $last_id = $PDO->lastInsertId();
          }
        }

        $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2]);

    }catch (PDOException $e){
      $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $e->getMessage());
      $PDO = null;
    }
    $PDO = null;
    return $last_id;
  }

  /**
   * Updates records in the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @return bool Whether the update was successful
   * @access public
   */
  public static function update(string $query, array $var = array()) : bool
  {
    $PDO = Db::connect();
    $result=0;
    try{
        $qr = $PDO->prepare($query);
        if(!$qr){
          $error = $PDO->errorInfo();
        }else{
          $i=1;
          foreach($var as $value){
            $qr->bindValue($i, $value);
            $i++;
          }
          $result = $qr->execute();
          if(!$result){
            $error = $qr->errorInfo();
          }else{
            $error = array(0,0,"Is ok!");
          }
          $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2], 'result' => $result);
          $qr->closeCursor();
        }
    }catch (PDOException $e){
      $PDO = null;
    }
    $PDO = null;
    return $result;
  }

  /**
   * Creates records in the database
   * @param string $query Query
   * @return bool Whether the creation was successful
   */
  public static function create(string $query) : bool
  {
    $resp = false;
    try{
        $PDO = Db::connect();
        $qr = $PDO->prepare($query);
        $i=1;
        if(!$qr){
          $error = $PDO->errorInfo();
        }else{
          $resp = $qr->execute();
          if(!$resp){
            $error = $qr->errorInfo();
          }else{
            $error = array(0,0,"Is ok!");
          }
        }

        $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => array(), 'error' => $error[2]);

    }catch (PDOException $e){
      $PDO = null;
    }
    $PDO = null;
    return $resp;
  }

  /**
   * Checks if a table exists
   * @param string $table Table name
   * @return bool
   * @access public
   */
  public static function tableIsExists(string $table) : bool
  {
    $PDO = Db::connect();
    $result = $PDO->query("SHOW TABLES LIKE '".$table."'");
    $PDO = null;
    if($result->rowCount() > 0){
      return true;
    }else{
      return false;
    }
  }
  
}

