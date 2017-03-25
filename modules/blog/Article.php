<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/12/2017
 * Time: 1:51 AM
 */

namespace modules\blog;

class Article {
    public $id, $title, $date, $author, $content, $published;
    public $tags = array();

    public function __construct($id, $title, $date, $author, $content, $published) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->author = $author;
        $this->content = $content;
        $this->published = $published;
        //$this->tags = $tags;
    }

    public function write(IArticleFactory $writer) {
        return $writer->write($this);
    }
}