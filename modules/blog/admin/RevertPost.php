<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/9/2017
 * Time: 11:31 AM
 */

namespace modules\blog\admin {

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);


    use framework\core\Authorize;
    use framework\core\User;
    use framework\database\Database;

    class RevertPost {

        public function revertPost(array $params, User &$USER) {
            $postID = $params['postID'];

            if (Authorize::AdminOnly($USER)) {
                if (isset ($postID)) {

                    $updateString = "postPublished = false WHERE postID = :postID";
                    $query_params = array(":postID" => $postID);
                    Database::update("blogPosts", $updateString, $query_params);
                    header("Location: ". ROOT . $USER->getRole());


                }
            }


        }

    }
}