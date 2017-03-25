<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/7/2017
 * Time: 2:05 PM
 */

namespace framework\database;

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

interface IConnect {

    // Set your database credentials here.
    // The use of PDO in this application provides support for multiple different databases.
    // Simply choose which database you want and enter the appropriate string for the DBTYPE variable
    // Available database drivers are as follows:
    //          Cubrid: "cubrid"
    //          MS SQL: "dblib"
    //      PostgreSQL: "pgsql"
    //          SQLite: "sqlite"
    //           MySQL: "mysql"
    //          Oracle: "oci"

    const DB_HOST = "localhost";
    const DB_NAME = "eserv";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "Slayer9891";
    const DB_DRIVER = "mysql";

}

