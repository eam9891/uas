<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/3/2017
 * Time: 3:26 PM
 */

namespace framework\core {


    abstract class IUserInterface {

        protected static $auth = false;
        protected static $htmlString;

        /**
         *  This abstract class is to be extended by all classes relating to a user interface.
         *  Each class must be authorized first before the html/js/css.. can be echo'd out.
         * @param  $html
         */
        public function __construct(&$html) {

            if (self::$auth) {
                self::$htmlString =& $html;
                $this->showUI();
            } else {
                header("Location: " .ROOT);
                die("Redirecting to: " .ROOT);
            }
        }

        private function showUI () {
            echo self::$htmlString;
        }
    }
}