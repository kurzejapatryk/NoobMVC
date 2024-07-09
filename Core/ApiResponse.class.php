<?php
namespace Core;

/**
 * Class ApiResponse
 * API response class
 * @package Core
 */
class ApiResponse{

    public $VERSION;
    public $ERROR = false;
    public $MSG = "OK!";

    public $RESULT;
    
    /**
     * Object constructor
     * @license https://opensource.org/licenses/mit-license.php MIT X11
     * @access public
     */
    function __construct(){
        $this->VERSION = API_VERSION;
        $this->RESULT = new \stdClass();
    }

    public function set($name, $value){
        if($name == "ERROR" || $name == "MSG"){
            $this->{$name} = $value;
        }else{
            $this->RESULT->{$name} = $value;
        }
        return $this;
    }

    /**
     * Generates JSON response
     * @author Patryk Kurzeja <patrykkurzeja@proton.me>
     * @license https://opensource.org/licenses/mit-license.php MIT X11
     * @access public
     */
    public function getJSON($header = true){
        if($header){
            header('Content-Type: application/json');
        }
        echo json_encode($this);
    }
}