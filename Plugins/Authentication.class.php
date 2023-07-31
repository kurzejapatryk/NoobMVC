<?php
/************************************************|
|* Description | Klasa uwierzytelniania         *|
|************************************************/

namespace Plugins;

use Plugins\Authentication\Models\Session;
use Plugins\Authentication\Models\User;

class Authentication{

    private $session;
    private $last_activity;
    private $auth_key;
    private $active_user;
    private $user;

    public function __construct(){
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_EXPIRED_TIME)) {
            $this->restart_session();
        }else{
          $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
          $this->last_activity = $_SESSION['LAST_ACTIVITY'];
          $this->session = session_id();
          if(isset($_SESSION['USER'])){
              $user = new User($_SESSION['USER']);
              $this->user = $user->get();
              if(isset($_SESSION['AUTH_KEY'])){
                  $this->auth_key = $_SESSION['AUTH_KEY'];
                  $session = new Session();
                  $session->getBySessionID($this->session);
                  if($session->auth_key == $this->auth_key){
                      $this->active_user = true;
                      $session->expired_datetime = date(DB_DATETIME_FORMAT, time() + SESSION_EXPIRED_TIME);
                      $session->save();
                  }else{
                      $this->restart_session();
                  }
              }else{
                  $this->restart_session();
              }
          }else{
               $this->restart_session();
          }
        }

    }

    private function restart_session(){
        session_regenerate_id(true);
        $this->user = new User();
        $this->session = session_id();
        $this->active_user = false;
    }

    private function gen_auth_key(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 128; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.md5(time());
    }

    public function is_log_in(){
        return $this->active_user;
    }

    public function get_user(){
        return $this->user;
    }

    public function log_out(){
        session_regenerate_id(true);
        $this->user = new User();
        $this->session = session_id();
    }

    public function log_in($user_name, $password){
        $user = new User();
        $user->getByUserName($user_name);
        if($user->password == md5($password . SALT)){
            $session = new session();
            $session->session_id = $this->session;
            $session->user_id = $user->id;
            $session->auth_key = $this->gen_auth_key();
            $session->create_datetime = date(DB_DATETIME_FORMAT);
            $session->expired_datetime = date(DB_DATETIME_FORMAT, time() + SESSION_EXPIRED_TIME);
            $session->save();
            $this->user = $user;
            $_SESSION['USER'] = $user->id;
            $_SESSION['LAST_ACTIVITY'] = time();
            $_SESSION['AUTH_KEY'] = $session->auth_key;

            return true;
        }else return false;
    }



}
