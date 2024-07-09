<?php
/************************************************|
|* Description | Authentication class            *|
|************************************************/

namespace Core;

use Core\Mailer;
use Models\Session;
use Models\User;
use Models\ResetPasswordCode;

/**
 * Authentication class
 * Class for authentication
 */
class Authentication{

    private $active_user;   //whether the user is logged in
    private $User;          //user object

    /**
     * Class constructor
     * Checks if the user is logged in
     * If yes, sets the user object
     * If not, creates a new user object
     * If the session has expired, restarts the session
     * @param Bool $renew - whether to renew the session (default true)
     */
    public function __construct($renew = true){
        if(isset($_SESSION['AUTH_KEY'])){
            $Session = new Session();
            $Session->getBySessionID(session_id());
            if($Session->auth_key == $_SESSION['AUTH_KEY']){
                if ($Session->expire_datetime > time()) {
                    $this->User = new User($Session->user_id);
                    if($renew){
                        $Session->expire_datetime =  time() + SESSION_EXPIRED_TIME;
                        $Session->save();
                    }
                    $this->active_user = true;
                }else{
                    $this->restart_session();  
                }
            }elseif($Session->auth_key){
                $this->restart_session();
            }else {
                $this->active_user = false;
                $this->User = new User();
            }
        }else{
            $this->User = new User();
            $this->active_user = false;
        }

    }

    /**
     * Function to restart the session
     * @return void
     */
    private function restart_session(){
        session_regenerate_id(true);
        $this->User = new User();
        $this->active_user = false;
    }

    /**
     * Function to generate an authentication key
     * @return string - authentication key
     */
    private function gen_auth_key(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 128; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.md5(time());
    }

    /**
     * Function to check if the user is logged in
     * @return bool - whether the user is logged in
     */
    public function is_log_in(){
        return $this->active_user;
    }

    /**
     * Function to check if the user is logged in as an administrator
     * @return bool - whether the user is logged in as an administrator
     */
    public function is_admin_log_in(){
        return( $this->active_user && $this->User->role == 1);
    }

    /**
     * Function to get the user object
     * @return object - user object
     */
    public function get_user(){
        return $this->User;
    }

    /**
     * Function to log out the user
     * @return void
     */
    public function log_out(){
        $Session = new Session();
        $Session->getBySessionID(session_id());
        $Session->expire_datetime = 0;
        $Session->save();
        $this->restart_session();
    }

    /**
     * Function to log in the user
     * @param string $user_name - username
     * @param string $password - password
     * @param bool $admin - whether the user is an administrator (default false)
     * @return bool - whether the login was successful
     */
    public function log_in($user_name, $password, $admin = false){
        $User = new User();
        $User->getByUserName($user_name);
        if($User->getPassword() == md5($password . SALT) && !$admin || $User->role){
            $auth_key = $this->gen_auth_key();
            $_SESSION['AUTH_KEY'] = $auth_key;
            $Session = new Session();
            $Session->session_id = session_id();
            $Session->user_id = $User->id;
            $Session->auth_key = $auth_key;
            $Session->created_datetime = date(DB_DATETIME_FORMAT);
            $Session->expire_datetime =  time() + SESSION_EXPIRED_TIME;
            $Session->save();
    
            $this->User = $User;
            $this->active_user = true;
            
            return true;
        }else return false;
    }

    /**
     * Function to generate a user password
     * @return string - user password
     * @access public
     */
    public function genPassword(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?!@#$%^&*()_+{}|:<>?~[]\;,./-=`';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Function to generate a 6-digit reset code
     * @return string - reset code
     * @access public
     * @static
     */
    public static function genResetCode(){
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    

    /**
     * Function to reset the user password
     * @param User $User - user object
     * @return bool - whether the password reset was successful
     * @access public
     */
    public function resetPassword($User){
        if($User->id){
            $code = $this->genResetCode();

            
            $to = $User->email;
            $subject = 'Reset Password';
            $HTMLmessage = '<html><body>';
            $HTMLmessage .= '<h1>Reset Password</h1>';
            $HTMLmessage .= '<p>Your password reset code is: <strong>'.$code.'</strong></p>';
            $HTMLmessage .= '<p>If you did not request a password reset, please ignore this message.</p>';
            $HTMLmessage .= '<p>This message was generated automatically, please do not reply.</p>';
            $HTMLmessage .= '</body></html>';

            // Use PHP's built-in mail function to send the email
            if(Mailer::send($to, $subject, $HTMLmessage)){
                $ResetPasswordCode = new ResetPasswordCode();
                $ResetPasswordCode->user_id = $User->id;
                $ResetPasswordCode->code = $code;
                $ResetPasswordCode->created_time = date(DB_DATETIME_FORMAT);
                $ResetPasswordCode->save();
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
