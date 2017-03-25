<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/18/2017
 * Time: 10:26 PM
 */

namespace framework\lib;
use modules\pub\models\LoginModel;


class Security {

    protected $username;
    protected $password;
    protected $loginModel;
    protected $encryptedPass;
    protected $validatePass;
    protected $login_ok = false;
    protected $bouncer;

    public function checkLogin($username, $password) {

        $this->username = $username;
        $this->password = $password;

        $this->login_ok = false;

        // First we get the users credentials using the User class.
        $this->loginModel = new LoginModel();
        $usr = $this->loginModel->getUser($this->username);

        // If $usr is true here we know it is a registered username and can continue
        if ($usr) {

            $USER = $this->loginModel->getUser($this->username);
            // Using the password submitted by the user and the salt stored in the database,
            // we can now check to see whether the passwords match by hashing the submitted password
            // and comparing it to the hashed version already stored in the database.
            $this->validatePass = new Encryption();
            $this->encryptedPass = $this->validatePass->eCrypt($this->password, $USER->getSalt());

            // If they match, then we can successfully log the user in.
            if ($this->encryptedPass == $USER->getPassword()) {

                // Flip login_ok to true
                $this->login_ok = true;

                // Flip active to true
                $USER->setActive(true);

                // To be safe lets unset all of the sensitive values here.
                unset($_POST['username']);
                unset($_POST['password']);

                // The Bouncer will take care of redirecting users based on access level.
                $this->bouncer = new Bouncer($this->login_ok, $USER);
                //return $USER;

            } else {

                // TODO: Implement some error reporting
                header("Location: ../index.php");
                die("Redirecting to: ../index.php");
            }
        } else {
            // TODO: Implement some error reporting
            header("Location: ../index.php");
            die("Redirecting to: ../index.php");
        }
    }
}