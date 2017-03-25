<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/13/2017
 * Time: 12:44 AM
 */

namespace framework\core;

class Authorize extends IUserInterface {

    public static function AdminOnly(User $obj) : bool {
        if ($obj->getRole() == "admin") {
            parent::$auth = true;
        } else {
            parent::$auth = false;
        }
        return parent::$auth;
    }

    public static function Contributor(User $obj) : bool {
        if ($obj->getRole() == "admin" || $obj->getRole() == "contributor") {
            parent::$auth = true;
        } else {
            parent::$auth = false;
        }
        return parent::$auth;
    }

    public static function User(User $obj) : bool {
        if ($obj->getRole() == "admin" || $obj->getRole() == "contributor" || $obj->getRole() == "user") {
            parent::$auth = true;
        } else {
            parent::$auth = false;
        }
        return parent::$auth;
    }
}