<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/12/2017
 * Time: 12:49 AM
 */
class IndexBody {
    public function __construct() {
        echo <<<HTML

<body>
<div class="container-fluid">

    <div class="col-sm-3">
        <div class="collapse navbar-collapse" id="sideNav">
            <div class="list-group">
                <a href="blog/" class="list-group-item">Blog</a>
                <a href="forum/" class="list-group-item">Forum</a>
                <a href="shop/" class="list-group-item">Shop</a>
                <a href="about/" class="list-group-item">About Us</a>
                <a href="contact/" class="list-group-item">Contact Us</a>
                <a href="contributor/" class="list-group-item">Contributors</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="panel-group">
            <div id="display">Coming Soon...</div>
            <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
                <img src='images/loader.gif' width="64" height="64" /><br>Loading..
            </div>
        </div>
    </div>

    <div class="col-sm-3 hidden-xs">
        <div class="sidebar-nav">
            <div class="navbar navbar-default" role="navigation">

                <div class="list-group">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Menu Item 1</a></li>
                        <li><a href="#">Menu Item 2</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Menu Item 4</a></li>
                        <li><a href="#">Reviews <span class="badge">1,118</span></a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>


    
</div>

</body>         
        
HTML;
    }
}