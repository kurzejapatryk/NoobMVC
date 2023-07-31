<?php
namespace Core;

class ApiResponse{

    public $VERSION;
    public $ERROR = false;
    public $MSG = "OK!";

    public $RESULT;
    
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
     * Generuje odpowiedź JSON
     * @author Patryk Kurzeja <patrykkurzeja@proton.me>
     * @license https://opensource.org/licenses/mit-license.php MIT X11
     * @access public
     */
    public function getJSON(){
        header('Content-Type: application/json');
        echo json_encode($this);
    }
}