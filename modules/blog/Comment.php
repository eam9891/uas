<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/11/2017
 * Time: 12:23 PM
 */

namespace modules\blog;


class Comment {
    public $commentID, $postID, $user, $comment, $date;
    public function __construct($commentID, $postID, $user, $comment, $date) {
        $this->commentID = $commentID;
        $this->postID = $postID;
        $this->user = $user;
        $this->comment = $comment;
        $this->date = $date;

    }

    public function write(ICommentFactory $writer) {
        return $writer->write($this);
    }
}