<?php
    /**
     * Created by PhpStorm.
     * User: Ethan
     * Date: 2/17/2017
     * Time: 4:32 PM
     */

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    spl_autoload_register(function($class) {
        include __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class) . '.php';
    });

    use framework\core\Framework;

    Framework::run();



