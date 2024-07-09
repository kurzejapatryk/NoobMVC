<?php
/************************************************|
|* Description | MySQL database controller      *|
|************************************************/

namespace Core;

use \PDO;
use \PDOException;

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
  public static function connect(){
    $con = null;
    try{
      $con = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD);
      $con->exec("SET CHARACTER SET utf8");
    }catch (PDOException $e) {
      define('SQL_ERROR', $e);
    }
    return $con;
  }

  /**
   * Retrieves records from the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @return string[] Result of the PDOStatement query
   * @access public
   */
  public static function select($query, $var = array(), $assoc = false){
    $con = Db::connect();
    $result = NULL;
    try{
      $qr = $con->prepare($query);
      if(!$qr){
         $error = $con->errorInfo();
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
      $con = null;
    }
    $con = null;
    return $result;
  }

  /**
   * Deletes records from the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @return integer Number of deleted records
   * @access public
   */
  public static function delete($query,$var = array()){
      $con = Db::connect();
      $result=0;
      try{
         $qr = $con->prepare($query);
         if(!$qr){
           $error = $con->errorInfo();
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
        $con = null;
    }
    $con = null;
    return $result;
  }


  /**
   * Adds a record to the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @return int Id of the new record
   * @access public
   */
  public static function insert($query,$var = array()){
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
      $con = null;
    }
    $con = null;
    return $last_id;
  }

  /**
   * Updates records in the database
   * @param string $query Query
   * @param mixed[] $var SQL query variables
   * @return int Number of modified elements
   * @access public
   */
  public static function update($query,$var = array()){
    $con = Db::connect();
    $result=0;
    try{
        $qr = $con->prepare($query);
        if(!$qr){
          $error = $con->errorInfo();
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
      $con = null;
    }
    $con = null;
    return $result;
  }

  /**
   * Creates records in the database
   * @param string $query Query
   * @return void
   */
  public static function create($query){
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
      $con = null;
    }
    $con = null;
    return $resp;
  }

  /**
   * Checks if a table exists
   * @param string $table Table name
   * @return bool
   * @access public
   */
  public static function tableExists($table){
    $con = Db::connect();
    $result = $con->query("SHOW TABLES LIKE '".$table."'");
    $con = null;
    if($result->rowCount() > 0){
      return true;
    }else{
      return false;
    }
  }
  
}

