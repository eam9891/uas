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
use framework\libs\Encryption;

class RegisterDB {
    private $stmt;
    private $role = "user";

    public function selectEmail(string $email) : bool {
        $query = "SELECT 1 FROM users WHERE email = :em";
        $query_params = array(":em" => "$email");

        try {
            $stmt = Database::connect()->prepare($query);
            $stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $row = $stmt->fetchColumn();

        if($row) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function selectUsername(string $username) {


        $query = "SELECT 1 FROM users WHERE username = :un";
        $query_params = array(":un" => "$username");

        try {
            $this->stmt = Database::connect()->prepare($query);
            $this->stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        $row = $this->stmt->fetchColumn();
        // If a cell was returned, then we know a matching username was found in
        // the database already and we should not allow the user to continue.
        if($row) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public function doRegistration(string $email, string $username, string $password) {
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
        $encryptedPass = $encryption->eCrypt($password, $salt);

        // Here we prepare our tokens for insertion into the SQL query.  We do not
        // store the original password; only the encrypted version of it.  We do store
        // the salt (in its plaintext form).
        $query_params = array (
            ':username' => $username,
            ':password' => $encryptedPass,
            ':salt' => $salt,
            ':email' => $email,
            ':role' => $this->role
        );

        try {
            $this->stmt = Database::connect()->prepare($query);
            $this->stmt->execute($query_params);
        }
        catch (\PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        echo "Success";

    }
}