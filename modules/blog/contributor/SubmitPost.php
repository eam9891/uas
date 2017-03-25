<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/4/2017
 * Time: 7:03 PM
 */

namespace modules\blog\contributor {

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    use framework\core\Authorize;
    use framework\core\User;
    use framework\database\Database;


    class SubmitPost {
        private $postTitle, $postCont, $postAuthor, $authorID;

        public function submitPost(array $params, User $USER) {

            if (Authorize::Contributor($USER)) {
                $this->postAuthor = $USER->getUsername();
                $this->authorID = $USER->getUserId();
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


            if(!isset($error)){

                try {

                    //insert into database
                    $query = '
                            INSERT INTO blogPosts (postTitle, postContent, postAuthor, authorID) 
                            VALUES (:postTitle, :postCont, :postAuthor, :authorID)
                        ';
                    $query_params = array(
                        ':postTitle' => $this->postTitle,
                        ':postCont' => $this->postCont,
                        ':postAuthor' => $this->postAuthor,
                        ':authorID' =>  $this->authorID
                    );
                    Database::insert($query, $query_params);

                    //redirect to index page
                    //header('Location: 192.168.0.132/undergroundartschool/'.$this->role.'/');
                    //header("Location: ". ROOT . $USER->getRole());

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