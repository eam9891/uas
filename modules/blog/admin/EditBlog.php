<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/11/2017
 * Time: 6:07 PM
 */

namespace modules\blog\admin {

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    use framework\core\Authorize;
    use framework\core\User;
    use modules\blog\TinyMCE;

    class EditBlog {

        public function request(User &$USER) {

            $tinyMce  = new TinyMCE();
            $tinyMce->destroy();

            if (Authorize::AdminOnly($USER)) {

                echo $tableHead = <<<HTML
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            
            <strong><i>
                Admin >> Edit Blog
            </i></strong>
            <select class="form-control" id="editBlogOrder" style="width: 20%; float: right;">
               
                <option value="DESC" selected> Descending </option>
                <option value="ASC"> Ascending </option>
                
            </select>
            <select class="form-control" id="editBlogOrderBy" style="width: 20%; float: right;">
               
                <option value="postID" selected> Post ID </option>
                <option value="postTitle"> Post Title </option>
                <option value="postDate"> Post Date </option>
                <option value="postAuthor"> Post Author </option>
                <option value="postPublished"> Post Published </option>
            </select>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
            
            
        </thead>
        <tbody id="editDisplay" style="text-align: left;"> 
            
        </tbody>
    </table>
</div>
                
HTML;





                echo $string = <<<HTML

<script>
    

    successRequest();

    function successRequest() {
        loader();
        var data;
        $.ajax({
            type: "POST",
            url: "http://www.eserv.us/blog/admin/getEditTable",
            data: {
                'params'  : {
                    'orderBy' : $('#editBlogOrderBy').val(),
                    'whichOrder' : $('#editBlogOrder').val()
                }
            },
            cache: false,
            success : function(data) {
                $("#editDisplay").hide().html(data).fadeIn();
            }
        });
    }
    
    

    $(document).ready(function() {
    
        $('#editBlogOrder').on('change' , function(){
            loader();
            var data;
            $.ajax({
                type: "POST",
                url: "http://www.eserv.us/blog/admin/getEditTable",
                data: {
                    'params'  : {
                        'orderBy' : $('#editBlogOrderBy').val(),
                        'whichOrder' : $('#editBlogOrder').val()
                    }
                },
                cache: false,
                success : function(data) {
                    $("#editDisplay").hide().html(data).fadeIn();
                }
            });
            return false;
        });
        
        $('#editBlogOrderBy').on('change' , function(){
            loader();
            var data;
            $.ajax({
                type: "POST",
                url: "http://www.eserv.us/blog/admin/getEditTable",
                data: {
                    'params'  : {
                        'orderBy' : $('#editBlogOrderBy').val(),
                        'whichOrder' : $('#editBlogOrder').val()
                    }
                },
                cache: false,
                success : function(data) {
                    $("#editDisplay").hide().html(data).fadeIn();
                }
            });
            return false;
        });
        
        
    });
</script>


HTML;


            }

        }

    }
}