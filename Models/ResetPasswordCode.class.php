<?php
namespace Models;

use Core\Model;

/**
 * Class ResetPasswordCode
 * Password reset code model
 * @package Models
 * @access public
 * @see Core\Model
 */
class ResetPasswordCode extends Model{

    /**
     * Table name in the database
     * @var string
     * @access protected
     */
    protected static $table = 'reset_password_codes';

    /**
     * Table schema
     * @var array
     * @access protected
     */
    protected static $schema = [
        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
        'user_id' => 'INT',
        'code' => 'VARCHAR(255) NULL',
        'created_time' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'used_time' => 'TIMESTAMP NULL DEFAULT NULL',
    ];

    /**
     * Reset password code ID
     * @var int
     * @access public
     */
    public $id;
    
    /**
     * User ID
     * @var int
     * @access public
     */
    public $user_id;
    
    /**
     * Reset code
     * @var string
     * @access public
     */
    public $code;
    
    /**
     * Creation time
     * @var string
     * @access public
     */
    public $created_time;

    /**
     * Usage time
     * @var string
     * @access public
     */
    public $used_time;

    /**
     * checkUser function
     * Function checks if the user has requested a password reset code within the last 5 minutes
     * @param User $User - user object
     * @return bool
     * @access public
     * @static
     */
    public static function checkUser($User){
        $Code = new ResetPasswordCode();
        $Code->user_id = $User->id;
        $Code->search();
        if($Code->id && $Code->code && $Code->used_time == null){
            $time = strtotime($Code->created_time);
            $now = time();
            if($now - $time < 300){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    /**
     * verifyCode function
     * Function checks if the code is valid and still valid
     * @param string $code - password reset code
     * @param User $User - user object
     * @return bool
     * @access public
     * @static
     */
    public static function verifyCode($code, $User){
        $Code = new ResetPasswordCode();
        $Code->code = $code;
        $Code->user_id = $User->id;
        $Code->search();
        if($Code->id && $Code->code){
            $time = strtotime($Code->created_time);
            $now = time();
            if($now - $time < 300){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * useCode function
     * Function sets the usage time of the code and checks if the code is valid
     * @param string $code - password reset code
     * @param User $User - user object
     * @return bool
     * @access public
     * @static
     */
    public static function useCode($code, $User){
        $Code = new ResetPasswordCode();
        $Code->code = $code;
        $Code->user_id = $User->id;
        $Code->search();
        if($Code->id && $Code->code){
            $time = strtotime($Code->created_time);
            $now = time();
            if($now - $time < 300){
                $Code->used_time = date('Y-m-d H:i:s');
                $Code->code = null;
                $Code->save();
                ResetPasswordCode::deactiveAllCodesForUser($User);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * deactiveAllCodesForUser function
     * Function deactivates all password reset codes for a user
     * @param User $User - user object
     * @return void
     * @access public
     * @static
     */
    public static function deactiveAllCodesForUser($User){
        $Codes = ResetPasswordCode::getAll(['user_id' => $User->id]);
        foreach($Codes as $Code){
            $Code->code = null;
            $Code->save();
        }
    }

}
