<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/11/2017
 * Time: 12:28 PM
 */

namespace modules\blog {

    use framework\database\Database;

    class CommentFactory ICommentFactory
    {

        public function getComments(Article $obj) {
            $query = "SELECT * FROM blogPostComments WHERE postID = $obj->id";
            $comments = Database::query($query);
            $numComments = $comments->rowCount();
            echo "<h4 style='text-align: center;'>$numComments Comments</h4>";
            while ($row = $comments->fetch()) {
                $comment = new Comment(
                    $row['commentID'],
                    $row['postID'],
                    $row['user'],
                    $row['comment'],
                    $row['commentDate']
                );
                $writer = new GetComments();
                echo $comment->write($writer);

            }

        }


    }
}