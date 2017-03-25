<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/11/2017
 * Time: 12:22 PM
 */

namespace modules\blog;


interface ICommentFactory {
    public function write(Comment $obj);
}