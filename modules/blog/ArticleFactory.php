<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/12/2017
 * Time: 2:02 AM
 */

namespace modules\blog;

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

use framework\core\Authorize;
use framework\core\User;
use framework\database\Database;

class ArticleFactory {

    public function getBlog() {
        $query = " SELECT * FROM blogPosts WHERE postPublished = TRUE ORDER BY postID DESC ";
        $blog = Database::query($query);
        echo <<<style

            <style>
                .panel-footer {
                    height: 50px;
                }
                .blog-panel {
                    margin-bottom: 10px;
                    
                }
                
            </style>
        
style;
        while ($row = $blog->fetch()) {
            $article = new Article(
                $row['postID'],
                $row['postTitle'],
                $row['postDate'],
                $row['postAuthor'],
                $row['postContent'],
                $row['postPublished']
            );
            $writer = new PreviewWriter();
            echo $article->write($writer);

        }

    }



    public function getPost($params) {
        $postID = $params[0];
        $query = " SELECT * FROM blogPosts WHERE postID = :postID";
        $query_params = array(":postID" => $postID);
        $blog = Database::select($query, $query_params);

        $article = new Article(
            $blog['postID'],
            $blog['postTitle'],
            $blog['postDate'],
            $blog['postAuthor'],
            $blog['postContent'],
            $blog['postPublished']
        );
        $writer = new ArticleWriter();
        echo $article->write($writer);

    }


    public function editBlog($params, User $USER){
        $orderBy = $params['orderBy'];
        $whichOrder = $params['whichOrder'];
        if (Authorize::AdminOnly($USER)) {

            $query = "
                    SELECT * FROM blogPosts WHERE readyForReview = TRUE OR postPublished = TRUE ORDER BY $orderBy $whichOrder
                ";
            $blogPosts = Database::query($query);
            while($row = $blogPosts->fetch()){
                $article = new Article(
                    $row['postID'],
                    $row['postTitle'],
                    $row['postDate'],
                    $row['postAuthor'],
                    $row['postContent'],
                    $row['postPublished']
                );
                $writer = new AdminWriter($article);
            }

            echo <<<ajaxRequests

<script>
    $('.editPost').on('click' , function(){
        loader();
        var data;
        $.ajax({
            type: "POST",
            url: "http://192.168.0.132/mvc/blog/contributor/editPost/",
            data: {
                'params'  : {
                    'postID' : $(this).val(),
                    
                }
            },
            cache: false,
            success : function(data) {
                $("#display").hide().html(data).fadeIn();
            }
        });
        return false;
    });

    $('.deletePost').on('click' , function(){
        loader();
        
        $.ajax({
            type: "POST",
            url: "http://192.168.0.132/mvc/blog/admin/deletePost/",
            data: {
                'params'  : {
                    'postID' : $(this).val(),
                    
                }
            },
            cache: false,
            success : function() {
                successRequest();
            }
        });
        return false;
    });
    
    $('.publishPost').on('click' , function(){
        loader();
        
        $.ajax({
            type: "POST",
            url: "http://192.168.0.132/mvc/blog/admin/publishPost/",
            data: {
                'params'  : {
                    'postID' : $(this).val()
                }
            },
            cache: false,
            success : function() {
                successRequest();
            }
        });
        return false;
    });
    
    $('.revertPost').on('click' , function(){
        loader();
        
        $.ajax({
            type: "POST",
            url: "http://192.168.0.132/mvc/blog/admin/revertPost/",
            data: {
                'params'  : {
                    'postID' : $(this).val()
                }
            },
            cache: false,
            success : function() {
                successRequest();
            }
        });
        return false;
    });
</script>
            
ajaxRequests;
        }

    }



}
?>
