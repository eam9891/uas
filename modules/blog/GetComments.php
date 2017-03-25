<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/11/2017
 * Time: 11:14 AM
 */

namespace modules\blog;


class GetComments implements ICommentFactory {


    public function write(Comment $obj)
    {

        $date = date('M, jS Y', strtotime($obj->date));
        $time = date('h:i A', strtotime($obj->date));

        echo <<<blogMainUI
        
<!-- Comment -->
<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="http://placehold.it/64x64" alt="">
    </a>
    <div class="media-body">
        <h4 class="media-heading">$obj->user
            <small>$date at $time</small>
        </h4>
        $obj->comment
    </div>
</div> 
            

           
   
    
blogMainUI;
    }
}