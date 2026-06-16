<?php
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
     * Factory method for creating user model.
     * @return User
     */
    protected function createUserModel() : User
    {
        return new User();
    }

    /**
     * Factory method for creating session model.
     * @return Session
     */
    protected function createSessionModel() : Session
    {
        return new Session();
    }

    /**
     * Class constructor
     * Checks if the user is logged in
     * If yes, sets the user object
     * If not, creates a new user object
     * If the session has expired, restarts the session
     * @param bool $renew - whether to renew the session (default true)
     */
    public function __construct(bool $renew = true)
    {
        if(isset($_SESSION['AUTH_KEY'])){
            $Session = $this->createSessionModel();
            $Session->getBySessionID(session_id());
            if($Session->auth_key == $_SESSION['AUTH_KEY']){
                if ($Session->expire_datetime > time()) {
                    $this->User = $this->createUserModel();
                    $this->User->id = (int)$Session->user_id;
                    $this->User->get();
                    if($renew){
                        $Session->expire_datetime =  time() + SESSION_EXPIRED_TIME;
                        $Session->save();
                    }
                    $this->active_user = true;
                }else{
                    $this->restartSession();  
                }
            }elseif($Session->auth_key){
                $this->restartSession();
            }else {
                $this->active_user = false;
                $this->User = $this->createUserModel();
            }
        }else{
            $this->User = $this->createUserModel();
            $this->active_user = false;
        }

    }

    /**
     * Function to restart the session
     * @return void
     */
    private function restartSession() : void
    {
        session_regenerate_id(true);
        $this->User = $this->createUserModel();
        $this->active_user = false;
    }

    /**
     * Function to generate an authentication key
     * @param int $length - length of the authentication key (default 128)
     * @return string - authentication key
     */
    private function gen_auth_key(int $length = 128) : string
    {
        $byteLength = (int) ceil($length / 2);
        return substr(bin2hex(random_bytes($byteLength)), 0, $length);
    }

    /**
     * Function to check if the user is logged in
     * @return bool - whether the user is logged in
     */
    public function isLogin() : bool
    {
        return $this->active_user;
    }

    /**
     * Function to check if the user is logged in as an administrator
     * @return bool - whether the user is logged in as an administrator
     */
    public function isAdmin() : bool
    {
        return( $this->active_user && $this->User->role == 1);
    }

    /**
     * Function to get the user object
     * @return object - user object
     */
    public function getUser() : User
    {
        return $this->User;
    }

    /**
     * Function to log out the user
     * @return void
     */
    public function logout() : void
    {
        $Session = $this->createSessionModel();
        $Session->getBySessionID(session_id());
        $Session->expire_datetime = 0;
        $Session->save();
        $this->restartSession();
    }

    /**
     * Function to log in the user
     * @param string $user_name - username
     * @param string $password - password
     * @param bool $admin - whether the user is an administrator (default false)
     * @return bool - whether the login was successful
     */
    public function login(string $user_name, string $password, bool $admin = false) : bool
    {
        $User = $this->createUserModel();
        $User->getByUserName($user_name);

        if(empty($User->id)){
            return false;
        }

        if($admin){
            if($User->role != 1) return false;
        }
        
        if($User->verifyPassword($password)){
            if($User->passwordNeedsRehash()){
                $User->setPassword($password);
                $User->save();
            }

            $auth_key = $this->gen_auth_key();
            $_SESSION['AUTH_KEY'] = $auth_key;
            $Session = $this->createSessionModel();
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
     * @param int $lenght - password length (default 12)
     * @return string - user password
     * @access public
     */
    public function genPassword(int $lenght = 12) : string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?!@#$%^&*()_+{}|:<>?~[]\;,./-=`';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenght; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Function to generate a 6-digit reset code
     * @param int $lenght - reset code length (default 6)
     * @return string - reset code
     * @access public
     * @static
     */
    public static function genResetCode(int $lenght = 6) : string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenght; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    

    /**
     * Function to reset the user password
     * @param User $User - user object
     * @return bool - whether the password reset was successful
     * @access public
     */
    public function resetPassword(User $User) : bool
    {
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
