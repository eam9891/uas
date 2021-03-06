<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/7/2017
 * Time: 1:13 PM
 */

namespace modules\login;

use framework\core\User;
use framework\database\Connect;
use framework\database\Database;
use framework\libs\Encryption;
use framework\libs\SessionManager;

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);


class LoginController extends ILogin {

    public function default($params) {

        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
        unset ($_POST['username']);
        unset ($_POST['password']);

        //$this->login = new Security();
        $this->checkLogin($this->username, $this->password);

    }

    public function checkLogin($username, $password) {

        $this->username = $username;
        $this->password = $password;

        // First we try to grab the username they entered from the database
        $query = "SELECT userID, username FROM users WHERE username = :un";
        $query_params = array(":un" => $this->username);
        $result = Database::select($query, $query_params);


        // If the $result returns true here we know it is a registered username and can continue
        if ($result['username']) {

            $query = "SELECT password, salt FROM users WHERE userID = :id";
            $query_params = array(":id" => $result['userID']);
            $pass = Database::select($query, $query_params);

            // Using the password submitted by the user and the salt stored in the database,
            // we can now check to see whether the passwords match by hashing the submitted password
            // and comparing it to the hashed version already stored in the database.
            $this->encryption = new Encryption();
            $this->encryptedPass = $this->encryption->eCrypt($this->password, $pass['salt']);

            // If they match, then we can successfully log the user in.
            if ($this->encryptedPass == $pass['password']) {

                $user = new User();
                $USER = $user->getUser($result['userID']);

                $time = date("Y-m-d H:i:s");
                $query = "UPDATE users SET activityTime = :thisTime WHERE userID = :userID ";
                $query_params = array (
                    ":userID" => $result['userID'],
                    ":thisTime" => $time
                );
                try {
                    $stmt = Database::connect()->prepare($query);
                    $stmt->execute($query_params);
                }
                catch (\PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }

                SessionManager::sessionStart("eMorris");
                SessionManager::sessionSet("id", $result['userID']);

                if ($USER->getRole() == "user") {
                    header("Location: " . ROOT . "home");
                    die("Redirecting to: " . ROOT . "home");
                }

                header("Location: " . ROOT . $USER->getRole());
                die("Redirecting to: " . ROOT . $USER->getRole());

            } else {
                $this->redirect();
            }
        } else {
            $this->redirect();
        }
    }

    public function redirect() {
        header("Location: " .ROOT);
        die("Redirecting to: " .ROOT);
    }
}

