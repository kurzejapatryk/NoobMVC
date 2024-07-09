<?php
namespace Models;

use Core\Model;

/**
 * Class Setting
 * Setting model
 * @package Models
 * @access public
 * @see Core\Model
 */
class Setting extends Model{

  /**
   * Table name in the database
   * @var string
   * @access protected
   */
  protected static $table = 'settings';

  /**
   * Table schema
   * @var array
   * @access protected
   */
  protected static $schema = [
    'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
    'name' => 'VARCHAR(255) NOT NULL',
    'value' => 'LONGTEXT',
  ];

  /**
   * Default settings
   * @var array
   * @access protected
   */
  protected static $default = [
    'PAGE_TITLE' => APP_NAME,
    //...
    //You can add more settings as needed
  ];

  /**
   * Setting identifier
   * @var int
   * @access public
   */
  public $id;

  /**
   * Setting name
   * @var string
   * @access public
   */
  public $name;

  /**
   * Setting value
   * @var string
   * @access public
   */
  public $value;

  /**
   * Saves default settings to the database
   * @return void
   * @access public
   * @static
   */
  public static function createDefaultSettings($echo = true){
    if($echo) echo "\n\n";
    foreach(self::$default as $name => $value){
      if(self::getValueByName($name) !== null){
        if($echo) echo $name."\e[93m Already exists\e[39m\n";
        continue;
      }
      $Setting = new Setting();
      $Setting->name = $name;
      $Setting->value = $value;
      $Setting->save();
      if($echo) echo $name."\e[32m ok\e[39m\n";
    }
    if($echo) echo "\n";
  }

  /**
   * Retrieves the value of a setting by name
   * @param string $name
   * @return string
   * @access public
   * @static
   */
  public static function getValueByName($name){
    $Setting = new Setting();
    $Setting->name = $name;
    $Setting->search();
    return $Setting->value;
  }

  /**
   * Sets the value of a setting by name
   * @param string $name
   * @param string $value
   * @return void
   * @access public
   * @static
   */
  public static function setValueByName($name, $value){
    $Setting = new Setting();
    $Setting->name = $name;
    $Setting->search();
    $Setting->value = $value;
    $Setting->save();
  }

  /**
   * Retrieves all settings
   * @return array
   * @access public
   * @static
   */
  public static function loadAll(){
    $settings = [];
    foreach(Setting::getAll() as $setting){
      $settings[$setting->name] = $setting->value;
    }
    return $settings;
  }

}
