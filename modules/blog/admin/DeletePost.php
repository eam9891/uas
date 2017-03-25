<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/5/2017
 * Time: 9:09 PM
 */

namespace modules\blog\admin {

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    use framework\core\Authorize;
    use framework\core\User;
    use framework\database\Database;

    class DeletePost {
        private $postID;

        public function deletePost(array $params, User &$USER) {


            if (Authorize::AdminOnly($USER)) {
                if (isset($params['postID'])) {
                    $this->postID = $params['postID'];
                    unset($params['postID']);
                } else {
                    $error = "No post ID set!";
                }



                if (!isset($error)) {

                    $query = "DELETE FROM blogPosts, blogPostComments WHERE postID = $this->postID";
                    Database::query($query);

                    header("Location: ". ROOT . $USER->getRole());

                } else {
                    echo $error;
                }
            }
        }

    }
}
