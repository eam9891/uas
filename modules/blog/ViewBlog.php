<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/12/2017
 * Time: 6:50 PM
 */

namespace modules\blog;


class ViewBlog {
    public function __construct() {
        echo <<<HTML
<body>
<div class="container">

    <div class="col-md-3">
        <div class="well" >
            <div class="list-group">
                <a href="../blog/" class="list-group-item">Blog</a>
                <a href="../forum/" class="list-group-item">Forum</a>
                <a href="../shop/" class="list-group-item">Shop</a>
                <a href="../about/" class="list-group-item">About Us</a>
                <a href="../contact/" class="list-group-item">Contact Us</a>
                <a href="../contributor/" class="list-group-item">Contributors</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-9">
        <div class="panel-group">
            <div id="display">
HTML;

        $mainBlog = new ArticleFactory();
        $mainBlog->getBlog();

        echo <<<HTML
            </div>
            <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
                <img src='http://www.eserv.us/public/images/loader.gif' width="64" height="64" /><br>Loading..
            </div>
        </div>
    </div>

    <!-- Blog Sidebar Widgets Column -->
    <div class="col-md-3">

        <!-- Blog Search Well -->
        <div class="well">
            <h4>Blog Search</h4>
            <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
            <!-- /.input-group -->
        </div>

        <!-- Blog Categories Well -->
        <div class="well">
            <h4>Blog Categories</h4>
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-unstyled">
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="list-unstyled">
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.row -->
        </div>

        <!-- Side Widget Well -->
        <div class="well">
            <h4>Side Widget Well</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
        </div>

    </div>


    
</div>

</body>         
        
HTML;
    }
}