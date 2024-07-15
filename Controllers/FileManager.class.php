<?php

namespace Controllers;

use \EdSDK\FlmngrServer\FlmngrServer;

use Core\Response;
use Core\Authentication;

use Models\File;

/**
 * Class FileManager
 * File management controller
 * @package Controllers
 * @access public
 */
class FileManager{

    public static function start() : void
    {
        \EdSDK\FlmngrServer\FlmngrServer::flmngrRequest(
            array(
                'dirFiles' => UPLOADS_DIR,
            )
        );
    }
}
