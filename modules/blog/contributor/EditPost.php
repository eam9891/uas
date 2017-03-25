<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/7/2017
 * Time: 7:32 PM
 */

namespace modules\blog\contributor;


use framework\core\Authorize;
use framework\core\User;
use framework\database\Database;
use framework\libs\AjaxHandler;
use modules\blog\Article;
use modules\blog\TinyMCE;


class EditPost {
    private $postID;
    private $error = [];
    public function editPost($params, User &$USER) {

        if (Authorize::Contributor($USER)) {
            if (isset($params['postID'])) {
                $this->postID = $params['postID'];
                unset($params['postID']);
            } else {
                $this->error = "No post ID set!";
            }

            $this->doEdit();


        }
    }

    private function doEdit() {


        if (!isset($error)) {

            $query = "SELECT * FROM blogPosts WHERE postID = $this->postID";
            $db = Database::query($query);
            $row = $db->fetch();
            $article = new Article(
                $row['postID'],
                $row['postTitle'],
                $row['postDate'],
                $row['postAuthor'],
                $row['postContent'],
                $row['postPublished']
            );

            $ajax = new AjaxHandler();

            $tinyMce = new TinyMCE();
            $editor = $tinyMce->init();

            echo <<<HTML

<form>
    
    <div class="form-group">
        <label for="postTitle"></label>
        <input type="text" class="form-control" id="postTitle" name="postTitle" value="$article->title" required>
        
    </div>
    
    <textarea class="editable" id="postCont" name="postCont" >
        $article->content
    </textarea>
    
    
    <button type='submit' class="submitEdits destroyTinyMce" >Submit Edit</button>
</form>

<script>

    $('.submitEdits').on('click' , function(){
    
        loader();
        
        $.ajax({
            type: "POST",
            url: "http://192.168.0.132/mvc/blog/contributor/submitEdit/",
            data: {
                'params'  : {
                    'postID' : "$article->id",
                    'postTitle' : $('#postTitle').val(),
                    'postCont' : $('#postCont').val()
                    
                }
            },
            cache: false,
            success : function(data) {
                    $("#display").html(data);
                }
        });
        return false;
    });
</script>

$editor
HTML;


        } else {
            echo $this->error;
        }
    }
}