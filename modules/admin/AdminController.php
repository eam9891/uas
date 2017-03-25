<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/5/2017
 * Time: 12:41 PM
 */

namespace modules\admin {


    use framework\core\Authorize;
    use framework\core\User;
    use framework\libs\SessionManager;
    use modules\chat\ChatWidget;
    use modules\contacts\ContactsWidget;
    use modules\home\HomeFooter;
    use modules\home\HomeHeader;

    class AdminController {

        public function default($params) {
            $USER = new User();
            $USER = $USER->getUser(SessionManager::getSessionID());
            if (Authorize::AdminOnly($USER)) {
                $head = new AdminHead($USER);
                $header = new HomeHeader($USER);
                $body = new AdminBody($USER);
                //$chat = new ChatWidget($USER);
                $contacts = new ContactsWidget($USER);
                //$footer = new AdminFooter($USER);
                $footer = new HomeFooter($USER);
            } else {
                header("Location: " .ROOT);
                die("Redirecting to: " .ROOT);
            }
        }



    }
}