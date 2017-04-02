<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/31/2017
 * Time: 12:34 AM
 */

namespace modules\register;

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

use framework\database\Database;

class RegisterDB {


    public function validateUsername(string $username) {

        $return = array();

        if(empty($this->username)) {
            $return['status'] = false;
            $return['msg'] = "Please enter a username.";

        } else {
            $query = "SELECT 1 FROM users WHERE username = :un";
            $query_params = array(":un" => "$this->username");

            try {
                $stmt = Database::connect()->prepare($query);
                $stmt->execute($query_params);
            }
            catch (\PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }

            $row = $stmt->fetchColumn();
            // If a cell was returned, then we know a matching username was found in
            // the database already and we should not allow the user to continue.
            if($row) {
                $return['status'] = false;
                $return['msg'] = "That username is already taken.";


                // Otherwise well return true here.
            } else {
                $return['status'] = "green";
                $return['msg'] = " ";

            }
        }

        return json_encode($return);

    }
}