<?php
namespace Core;

/**
 * Class ApiResponse
 * API response class
 * @package Core
 */
class ApiController{

    public $VERSION;
    public $ERROR = false;
    public $MSG = "OK!";

    public $RESULT;
    
    /**
     * Object constructor
     * @access public
     */
    function __construct(){
        $this->VERSION = API_VERSION;
        $this->RESULT = new \stdClass();
    }

    /**
     * Sets the response value
     * @param string $name Value name
     * @param mixed $value Value
     * @return ApiResponse
     * @access public
     */
    public function set(string $name, $value) : self
    {
        if($name == "ERROR" || $name == "MSG"){
            $this->{$name} = $value;
        }else{
            $this->RESULT->{$name} = $value;
        }
        return $this;
    }

    /**
     * Generates JSON response
     * @return string|false JSON response
     * @access public
     */
    public function getJSON() : string|false
    {
        return json_encode($this);
    }

    /**
     * Display JSON response
     * @param bool $header Whether to set JSON header
     * @return void
     * @access public
     */
    public function display(bool $header = true) : void
    {
        if($this->ERROR){
            http_response_code(500);
        }
        if($header){
            header('Content-Type: application/json');
        }
        echo $this->getJSON();
    }

}