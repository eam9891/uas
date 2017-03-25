<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/12/2017
 * Time: 2:33 AM
 */

namespace modules\blog {

    use framework\libs\AjaxHandler;

    class PreviewWriter implements IArticleFactory {



        public function write(Article $obj) {

            $date = date('M jS Y', strtotime($obj->date));
            $time = date('h:i A', strtotime($obj->date));
            $panelID = "p".$obj->id;
            $comments = new CommentFactory();
            $viewPost = ROOT."blog/viewPost/$obj->id";



            echo <<<previewPost
        
<div class="panel panel-default blog-panel">
    <div class="panel-heading">
        <h3>$obj->title</h3>
        <p>$date</p>
    </div>
    <div class="panel-body " id="$panelID"style="height: 400px; overflow: hidden;" >$obj->content</div>
    <div class="panel-footer">
        <p class="pull-left" style="width:40%;">Posted by <a href="">$obj->author</a> <br> $time</p>
        <a href="$viewPost" class="btn btn-default pull-right" > 
            READ MORE
        </a>
        
    </div>
                
previewPost;

           $comments->getComments($obj);
           echo <<<previewClosing



</div><br><br>


previewClosing;


        }
    }
}

