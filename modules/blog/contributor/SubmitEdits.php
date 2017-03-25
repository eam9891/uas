<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/9/2017
 * Time: 5:57 PM
 */

namespace modules\blog\contributor {


    use framework\core\Authorize;
    use framework\core\User;
    use framework\database\Database;
    use framework\libs\Authenticate;
    use modules\blog\TinyMCE;

    class SubmitEdits {
        private $postTitle, $postCont, $postAuthor, $postID;

        public function submitEdits(array $params, User &$USER) {

            if (Authorize::Contributor($USER)) {

            }

            // Make sure we have a title
            if(isset($params['postTitle'])) {
                $this->postTitle = $params['postTitle'];
                unset($params['postTitle']);
            } else {
                $error[] = 'Please enter the title.';
            }

            // Make sure we have content
            if(isset($params['postCont'])) {
                $this->postCont = $params['postCont'];
                unset($params['postCont']);
            } else {
                $error[] = 'Please enter the content.';
            }

            // Make sure we know which table to store it in
            if(isset($params['postID'])) {
                $this->postID = $params['postID'];
                unset($params['postID']);
            } else {
                $error[] = 'Error: Undefined postID!';
            }


            if(!isset($error)){

                try {

                    $setString = "
                        postTitle = :postTitle, postContent = :postCont
                        WHERE postID = :postID
                    ";
                    $query_params = array(
                        ":postID" => $this->postID,
                        ':postTitle' => $this->postTitle,
                        ':postCont' => $this->postCont,

                    );
                    Database::update("blogPosts", $setString, $query_params);

                    $tinyMce = new TinyMCE();
                    $tinyMce->destroy();
                    //redirect to index page
                    //header('Location: 192.168.0.132/undergroundartschool/'.$this->role.'/');
                    header("Location: ". ROOT . $USER->getRole());

                } catch(\PDOException $e) {
                    echo $e->getMessage();
                }

            } else {
                foreach ($error as $err) {
                    echo $err;
                }

            }
        }
    }

}