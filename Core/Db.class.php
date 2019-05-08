<?php
/************************************************|
|* Author      | Patryk Kurzeja                 *|
|* Date        | 15-11-2017                     *|
|* email       | p.kurzeja@spheresystems.pl     *|
|* Project     | SphereFramefork                *|
|* Description | Kontroler bazy danych mysql    *|
|************************************************/


namespace Core;
use \PDO;

class Db{

  /**
   * Nawiązuje połączenie z bazą
   * @author Patryk Kurzeja <p.kurzeja@spheresystems.pl>
   * @return object połączenie z bazą w PDO
   * @license https://opensource.org/licenses/mit-license.php MIT X11
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
   * Pobiera rekordy z bazy
   * @author Patryk Kurzeja <p.kurzeja@spheresystems.pl>
   * @param string $query Zapytanie
   * @param mixed[] $var zmienne do zapytania SQL
   * @return string[] Wynik zapytania PDOStatement
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function select($query,$var = array(), $assoc = false){
    $con = Db::connect();
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
          if(SQL_DEBUG){
            $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2]);
          }
        }
    }catch (PDOException $e){
      $con = null;
    }
    $con = null;
    return $result;
  }

  /**
   * Usuwa rekordy
   * @author Patryk Kurzeja <p.kurzeja@spheresystems.pl>
   * @param string $query Zapytanie
   * @param mixed[] $var zmienne do zapytania SQL
   * @return integer Liczba usunietych rekordów
   * @license https://opensource.org/licenses/mit-license.php MIT X11
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
             if(SQL_DEBUG){
               $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2]);
             }
  				   $qr->closeCursor();
           }
			}catch(PDOException $e) {
        $con = null;
		}
    $con = null;
		return $result;
  }


  /**
   * Dodaje rekord do bazy
   * @author Patryk Kurzeja <p.kurzeja@spheresystems.pl>
   * @param string $query Zapytanie
   * @param mixed[] $var zmienne do zapytania SQL
   * @return int Id nowego rekordu
   * @license https://opensource.org/licenses/mit-license.php MIT X11
   * @access public
   */
  public static function insert($query,$var = array()){
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
            $id = $PDO->lastInsertId();
    				$qr->closeCursor();
            $last_id = $PDO->lastInsertId();
          }
        }

        if(SQL_DEBUG){
          $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2]);
        }

    }catch (PDOException $e){
      $con = null;
    }
    $con = null;
    return $last_id;
  }

  /**
   * Aktualizuje rekordy w bazie
   * @author Patryk Kurzeja <p.kurzeja@spheresystems.pl>
   * @param string $query Zapytanie
   * @param mixed[] $var zmienne do zapytania SQL
   * @return int liczba zmodyfikowanych elementów
   * @license https://opensource.org/licenses/mit-license.php MIT X11
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
          if(SQL_DEBUG){
            $GLOBALS['SQL_DEBUG_ARRAY'][] = array('SQL' => $query, 'vars' => $var, 'error' => $error[2]);
          }
  				$qr->closeCursor();
        }
    }catch (PDOException $e){
      $con = null;
    }
    $con = null;
    return $result;
  }
}
