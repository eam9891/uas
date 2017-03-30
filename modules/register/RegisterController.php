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

    public function __construct() {
        if (!empty($_POST['un'])){
            $this->username = $_POST['un'];
            unset ($_POST['un']);
        }

        if (!empty($_POST['pw'])){
            $this->password = $_POST['pw'];
            unset ($_POST['pw']);
        }

        if (!empty($_POST['email'])){
            $this->email = $_POST['email'];
            unset ($_POST['email']);
        }


    }

    public function default($params) {

        $this->validateUsername();
        //$this->validateEmail();




        // Ensure that the user has entered a non-empty password
        if(empty($this->password)) {
            die("Please enter a password.");
        }

        // Make sure the user entered a valid E-Mail address.
        // filter_var is a useful PHP function for validating form input, see:
        // http://us.php.net/manual/en/function.filter-var.php
        // http://us.php.net/manual/en/filter.filters.php
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid E-Mail Address");
        }

        // First an sql query will check if the username they want is in use or not.
        // The selectOne() function is part of a custom wrapper on the PDO library.
        // Here we use PDO prepared statements. These statements have special tokens
        // (technically called parameters) to protect against SQL injection attacks.
        // For more information on SQL injections, see Wikipedia:
        // http://en.wikipedia.org/wiki/SQL_Injection




        // Now we perform the same type of check for the email address, in order
        // to ensure that it is unique.
        $this->row = Database::selectOne("users", "email = ?", [$this->email]);

        if($this->row)
        {
            die("This email address is already registered");
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


        // This redirects the user back to the index/login page after they registerForm
        header("Location: ".ROOT);

        // Calling die or exit after performing a redirect using the header function is critical.
        // The rest of your PHP script will continue to execute and will be sent to the user if you do not die or exit.
        die("Redirecting to ".ROOT);
    }

    public function validateUsername() {

        $return = array();


        if(empty($this->username)) {
            $return['username'] = "That username is not valid.";
            echo json_encode($return);
            return false;
        } else {
            // This function takes three parameters, the table name, the where
            // clause, and the query parameters, and it returns a single cell.
            $this->row = Database::selectOne("users", "username = ?", [$this->username]);

            // If a cell was returned, then we know a matching username was found in
            // the database already and we should not allow the user to continue.
            if($this->row) {
                $return['username'] = "That username is already taken.";
                echo json_encode($return);
                return false;

            // Otherwise well return true here.
            } else {
                return true;
            }
        }

    }

    public function validateEmail() {

    }

}