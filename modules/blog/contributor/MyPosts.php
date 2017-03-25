<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/17/2017
 * Time: 8:28 PM
 */

namespace modules\blog\contributor {

    use framework\core\Authorize;
    use framework\core\User;

    class MyPosts {

        public function getMyPosts(array $params, User &$USER) {
            if (Authorize::Contributor($USER)) {
                echo <<<HTML

<div class="table-responsive">
<table class="table table-hover">
    <thead>
        
        <strong><i>
            Admin >> Edit Blog
        </i></strong>
        
        <select class="form-control" style="width: 20%; float: right;">
            <option value="" disabled selected>Order By: </option>
            <option value="1"></option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Author</th>
            <th>Action</th>
        </tr>
        
        
    </thead>
    <tbody style="text-align: left;">           
        
HTML;
            }


        }

    }
}