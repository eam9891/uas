<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/17/2017
 * Time: 3:10 PM
 */

namespace framework\core;

use framework\libs\SessionManager;

abstract class Framework {


    public static function run() {
        self::init();
    }

    private static function init() {

        // include configs
        include "framework/config/config.php";

        SessionManager::sessionStart("eserv");

        // Start the request/router
        $requests = new Request();
    }



}

