<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/5/2017
 * Time: 11:29 PM
 */

namespace modules\blog\admin {

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);


    use framework\core\Authorize;
    use framework\core\User;
    use framework\database\Database;


    class PublishPost {

        public function publishPost(array $params, User &$USER) {
            $postID = $params['postID'];

            if (Authorize::AdminOnly($USER)) {
                if (isset ($postID)) {

                    $updateString = "postPublished = true WHERE postID = :postID";
                    $query_params = array(":postID" => $postID);
                    Database::update("blogPosts", $updateString, $query_params);
                    header("Location: ". ROOT . $USER->getRole());

                }
            }


        }
    }

}