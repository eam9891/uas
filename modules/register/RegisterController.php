<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/7/2017
 * Time: 1:28 PM
 */

namespace modules\register;

use framework\database\Database;
use framework\libs\Encryption;

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);


class RegisterController {
    private $username;
    private $password;
    private $email;
    private $stmt;
    private $row;
    private $role = "user";
    private $registerDB;

    public function __construct() {
        if (!empty($_POST['un'])){
            $this->username = $_POST['un'];
            unset ($_POST['un']);
        }

        if (!empty($_POST['pw'])){
            $this->password = $_POST['pw'];
            unset ($_POST['pw']);
        }

        if (!empty($_POST['em'])){
            $this->email = $_POST['em'];
            unset ($_POST['em']);
        }

        $this->registerDB = new RegisterDB();

    }

    public function default($params) {

        $this->validateUsername();
        $this->validateEmail();
        //$this->validatePassword();

        // Ensure that the user has entered a non-empty password
        if(empty($this->password)) {
            die("Please enter a password.");
        }



        // Here we are preparing to insert the users credentials into the database,
        // again we are using PDO prepared statements with tokens.
        $query = "
            INSERT INTO users (
                username,
                password,
                salt,
                email,
                role
            ) VALUES (
                :username,
                :password,
                :salt,
                :email,
                :role
            )
        ";

        // Before we execute our query, it is better to do some password encryption first.
        // That way the users password is never stored in plaintext in the database.
        // Using the Encryption class we generate a salt (a long random string),
        // and hash the password with the salt concatenated on the end.
        // Check out the Encryption class for more information on how it works.
        $encryption = new Encryption();
        $salt = $encryption->generateSalt();
        $encryptedPass = $encryption->eCrypt($this->password, $salt);

        // Here we prepare our tokens for insertion into the SQL query.  We do not
        // store the original password; only the encrypted version of it.  We do store
        // the salt (in its plaintext form).
        $query_params = array (
            ':username' => $this->username,
            ':password' => $encryptedPass,
            ':salt' => $salt,
            ':email' => $this->email,
            ':role' => $this->role
        );

        $this->stmt = Database::insert($query, $query_params);


        echo "success!";
    }

    public function validateUsername() {

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

        echo json_encode($return);

        //$json = $this->registerDB->validateUsername($this->username);
        //echo $json;
    }

    public function validateEmail() {


        $return = array();

        if(empty($this->email)) {
            $return['status'] = false;
            $return['msg'] = "Please enter an email address.";

        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $return['status'] = false;
            $return['msg'] = "Please enter a valid email address.";
        } else {
            $query = "SELECT 1 FROM users WHERE email = :em";
            $query_params = array(":em" => "$this->email");

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
                $return['msg'] = "That email is already in use.";


                // Otherwise well return true here.
            } else {
                $return['status'] = "green";
                $return['msg'] = " ";

            }
        }

        echo json_encode($return);
    }

}