<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/4/2017
 * Time: 6:15 PM
 */

namespace modules\blog\contributor {

    use framework\core\Authorize;
    use framework\core\User;
    use modules\blog\TinyMCE;

    class NewPost {
        private $user;
        public function newPost(User $obj) {

            if (Authorize::Contributor($obj)) {
                $this->user = $obj->getUsername();

                $tinyMce = new TinyMCE();
                $tinyMce->destroy();
                $editorInit = $tinyMce->init();

                echo <<<HTML

<form>
    <div class="form-group">
        <label for="postTitle"></label>
        <input type="text" class="form-control" id="postTitle" name="postTitle" placeholder="Enter A Post Title" required>
    </div>
    <textarea class="editable" id="postCont" name="postCont"></textarea>
    <button type='submit' id='submitPost'>Submit Post</button>
</form>
<script>
    $('#submitPost').on('click' , function(){
       
        loader();
        
        $.ajax({
            type: "GET",
            url: "http://192.168.0.132/mvc/blog/contributor/submitPost/",
            data: {
                "params" : {
                    'postTitle' : $('#postTitle').val(),
                    'postCont' : $('#postCont').val()
                }
            },
            cache: false,
            success : function() {
                    $.ajax({
                        type: "POST",
                        url: "blog/admin/editBlog/",
                        data: {"params":{"orderBy":"postID","whichOrder":"DESC"}},
                        success : function(data) {
                            $("#display").hide().html(data).fadeIn();
                        }
                    });
                }
        });
        return false;
    });
</script>

$editorInit
         
HTML;
            }
        }


    }
}