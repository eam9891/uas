<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/3/2017
 * Time: 6:22 PM
 */

namespace modules\admin {


    use framework\core\Authorize;
    use framework\core\IUserInterface;
    use framework\core\User;
    use framework\database\Database;

    class AdminBody extends IUserInterface
    {
        public function __construct(User &$USER)
        {
            parent::$auth = Authorize::AdminOnly($USER);
            $username = $USER->getUsername();
            $userRole = $USER->getRole();
            $email = $USER->getEmail();

            // Url for home button
            $homeButton = ROOT . $USER->getRole();

            // Get num of posts for review
            $query = "SELECT * FROM blogPosts WHERE readyForReview = TRUE AND postPublished = FALSE ";
            $numReviews = Database::query($query);
            $numReviews = $numReviews->rowCount();
            $root = ROOT;
            self::$htmlString = <<<HTML
     
<div class="container-fluid text-center">
    <div class="row">

        <div class="col-md-3 col-sm-3 ">
            <div class="well">
                <img src="$root/public/images/img_avatar2.png" class="" height="65" width="65" alt="Avatar">
                <p>
                    <a href="#">$username</a><br>
                    <small>$userRole</small>
                </p>
            </div>
             
            <div class="panel-group">
                <div class="panel panel-default">
                    <ul class="nav nav-stacked" style="text-align: left;">
                        <li class="nav-header"> 
                            <button id="userMenuButton" data-toggle="collapse" data-target="#userMenu" class="menuButton">
                                Settings 
                                <span id="userMenuArrow" class="glyphicon glyphicon-chevron-right"></span>
                            </button>
                            <ul class="nav nav-stacked collapse" id="userMenu">
                                <li class="active"> <a href="$homeButton"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                                <li><a href="#" id="showContactWidget"><i class="glyphicon glyphicon-envelope"></i> Messages <span class="badge badge-info">4</span></a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Options</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-comment"></i> Shoutbox</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-user"></i> Staff List</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-flag"></i> Transactions</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-exclamation-sign"></i> Rules</a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-header"> 
                            <button id="blogToolsButton" data-toggle="collapse" data-target="#blogTools" class="menuButton"> 
                                Blog Tools 
                                <span href="" id="blogToolsArrow" class="glyphicon glyphicon-chevron-down"></span>
                            </button>
                            <ul class="nav nav-stacked collapse in" id="blogTools">
                                <li class="active"><a href="" id="editBlog" value="EditBlog" > Edit Blog <span class="label label-success" id="getNumReviews"> $numReviews </span></a></li>
                                <li><a href="" id="showBlog" value="ArticleFactory"> Show Blog </a></li>
                                <li><a href="" id="newPost" value="NewPost"> New Post </a></li>
                                <li><a href="" id="myPosts"> My Posts </a></li>
                                <li><a href="#"> Alerts </a></li>
                            </ul>
                        </li>
                        
                    </ul>
                        
                    
                    
                </div>
            </div>
          
        </div>

        <!-- This is where all requests get displayed -->
        <div class="col-md-9 col-sm-9">
            <div id="display"></div>
            <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
                <img src='http://192.168.0.132/mvc/public/images/loader.gif' width="64" height="64" /><br>Loading..
            </div>
        </div>
        
    </div>
</div>
HTML;
            parent::__construct(self::$htmlString);
        }
    }
}