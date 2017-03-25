<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/17/2017
 * Time: 7:20 PM
 */

namespace modules\home;


use framework\core\Authorize;
use framework\core\User;
use framework\libs\SessionManager;
use modules\contacts\ContactsWidget;

class HomeController {

    public function default($params) {
        $USER = new User();
        $USER = $USER->getUser(SessionManager::getSessionID());
        if (Authorize::User($USER)) {

            $head = new HomeHead($USER);
            $header = new HomeHeader($USER);
            $body = new HomeBody($USER);
            $contacts = new ContactsWidget($USER);
            $footer = new HomeFooter($USER);
        } else {
            header("Location: " .ROOT);
            die("Redirecting to: " .ROOT);
        }
    }

}