<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/12/2017
 * Time: 1:50 AM
 */
namespace modules\blog;

class JSONWriter implements IArticleFactory {
    public function write(Article $obj) {
        $array = array('article' => $obj);
        return json_encode($array);
    }
}