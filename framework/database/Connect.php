<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/7/2017
 * Time: 1:31 PM
 */

namespace framework\database;

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

use PDO;
use PDOException;

abstract class Connect implements IConnect {

    protected static $server = IConnect::DB_HOST;
    protected static $currentDB = IConnect::DB_NAME;
    protected static $user = IConnect::DB_USERNAME;
    protected static $pass = IConnect::DB_PASSWORD;
    protected static $dbtype = IConnect::DB_DRIVER;
    protected static $connection;

    protected static function openConnection() {
        $serv = self::$server;
        $dbn = self::$currentDB;
        $usr = self::$user;
        $pw = self::$pass;
        $dbt = self::$dbtype;

        // This sets the database connection string automatically.
        self::$connection = new PDO("$dbt:host={$serv};dbname={$dbn};charset=utf8", $usr, $pw);

        try {
            self::$connection;
        }

        catch(PDOException $ex) {
            die("Failed to connect to the database: " . $ex->getMessage());
        }

        // This statement configures PDO to throw an exception when it encounters
        // an error.  This allows us to use try/catch blocks to trap database errors.
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // This statement configures PDO to return database rows from your database using an associative
        // array.
        self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // This block of code is used to undo magic quotes.  Magic quotes are a terrible
        // feature that was removed from PHP as of PHP 5.4.  However, older installations
        // of PHP may still have magic quotes enabled and this code is necessary to
        // prevent them from causing problems.  For more information on magic quotes:
        // http://php.net/manual/en/security.magicquotes.php
        if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            function undo_magic_quotes_gpc(&$array) {
                foreach($array as &$value) {
                    if(is_array($value)) {
                        undo_magic_quotes_gpc($value);
                    }
                    else {
                        $value = stripslashes($value);
                    }
                }
            }
            undo_magic_quotes_gpc($_POST);
            undo_magic_quotes_gpc($_GET);
            undo_magic_quotes_gpc($_COOKIE);
        }

        return self::$connection;
    }
}