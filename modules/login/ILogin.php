<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/10/2017
 * Time: 11:16 AM
 */

namespace modules\login;

abstract class ILogin {

    protected $username;
    protected $password;
    protected $encryptedPass;
    protected $encryption;
    protected $stmt;
    protected $login_ok = false;
    protected $row;
    protected $userID;

    abstract function checkLogin($username, $password);
}