<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/12/2017
 * Time: 1:07 PM
 */

use framework\core\User;
use framework\core\Authorize;
use framework\libs\SessionManager;

class PublicController  {

    public function default() {

        // Check if they are logged in
        if (SessionManager::getSessionID()) {
            $USER = new User();
            $USER = $USER->getUser(SessionManager::getSessionID());

            // Check if they are authorized
            if (Authorize::User($USER)) {
                $head = new \modules\home\HomeHead($USER);
                $header = new \modules\home\HomeHeader($USER);
            } else {
                $head = new IndexHead();
                $header = new IndexHeader();
            }

        } else {
            $head = new IndexHead();
            $header = new IndexHeader();
        }

        $body = new IndexBody();
        $footer = new IndexFooter();
    }
}
