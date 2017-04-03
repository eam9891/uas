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
    private $registerDB;
    private $regStatus = [];


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

        $this->validateEmail();
        $this->validatePassword();
        $this->validateUsername();

        if ($this->regStatus['email'] == true && $this->regStatus['username'] == true && $this->regStatus['password'] == true) {
            $this->registerDB->doRegistration($this->email, $this->username, $this->password);

        } else {
            header("Location: " . ROOT);
        }



    }

    public function validateEmail() {

        $return = array();

        if(empty($this->email)) {
            $this->regStatus['email'] = false;
            $return['status'] = false;
            $return['msg'] = "Please enter an email address.";
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->regStatus['email'] = false;
            $return['status'] = false;
            $return['msg'] = "Please enter a valid email address.";
        }

        if($this->registerDB->selectEmail($this->email)) {
            $this->regStatus['email'] = false;
            $return['status'] = false;
            $return['msg'] = "That email is already in use.";

        } else {
            $this->regStatus['email'] = true;
            $return['status'] = "green";
            $return['msg'] = " ";
        }


        echo json_encode($return);
    }

    public function validateUsername() {

        $return = array();

        if(empty($this->username)) {
            $this->regStatus['username'] = false;
            $return['status'] = false;
            $return['msg'] = "Please enter a username.";

        } else {

            if($this->registerDB->selectUsername($this->username)) {
                $this->regStatus['username'] = false;
                $return['status'] = false;
                $return['msg'] = "That username is already taken.";


                // Otherwise well return true here.
            } else {
                $this->regStatus['username'] = true;
                $return['status'] = "green";
                $return['msg'] = " ";

            }
        }

        echo json_encode($return);

        //$json = $this->registerDB->validateUsername($this->username);
        //echo $json;
    }

    public function validatePassword() {

        $return = array();

        // Ensure that the user has entered a non-empty password
        if(empty($this->password)) {
            $this->regStatus['password'] = false;
            $return['status'] = false;
            $return['msg'] = "Please enter a password.";
        } else {
            $this->regStatus['password'] = true;
            $return['status'] = "green";
            $return['msg'] = " ";
        }

        echo json_encode($return);
    }

}