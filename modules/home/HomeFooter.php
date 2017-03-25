<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/3/2017
 * Time: 2:40 PM
 */

namespace modules\home {

    use framework\core\Authorize;
    use framework\core\IUserInterface;
    use framework\core\User;


    class HomeFooter extends IUserInterface {

        public function __construct(User &$USER) {
            parent::$auth = Authorize::User($USER);
            self::$htmlString = <<<HTML
            
            
            </body>
            </html>
           
HTML;
            parent::__construct(self::$htmlString);
        }
    }
}