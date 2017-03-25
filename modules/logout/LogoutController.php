<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/21/2017
 * Time: 12:44 PM
 */

namespace modules\logout;


use framework\libs\SessionManager;

class LogoutController {
    public function default() {
        SessionManager::sessionUnset("eMorris");
        SessionManager::sessionUnset("id");
        header("Location: ".ROOT);
        header("Location: ".ROOT);
    }
}