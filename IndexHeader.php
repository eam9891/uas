<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/12/2017
 * Time: 1:09 AM
 */
class IndexHeader {
    public function __construct() {
        $header = <<< HTML

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topNav, #sideNav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://www.eserv.us">Underground Art School</a>
        </div>
        <div class="collapse navbar-collapse" id="topNav">
            
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Navigate <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="http://www.eserv.us/blog/">Blog</a></li>
                        <li><a href="#">Forum</a></li>
                        <li><a href="#">Shop</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Become a Contributor!</a></li>
                    </ul>
                </li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <!-- Trigger the register modal with a button-->
                <li><a href="" data-toggle="modal" data-target="#registerModal"><span class="glyphicon glyphicon-user"></span> Sign Up </a></li>
                <!-- Trigger the login modal with a button-->
                <li><a href="" data-toggle="modal" data-target="#loginModal"><span class="glyphicon glyphicon-user"></span> Login </a></li>
            </ul>

        </div>
    </div>
</nav>

<!-- Register Modal -->
<div id="registerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
                <h4 class="modal-title">Registration</h4>
            </div>
            <div class="modal-body">
                <form action="http://www.eserv.us/register/" method="POST">
                    <div class="form-group">
                        <label for="email">
                            Enter Your Email Address:
                            <div id="validateEmail"></div>
                        </label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="un">
                            Enter A Username:
                            <div id="validateUsername"></div>
                        </label>
                        <input type="text" class="form-control" id="username" name="un">
                    </div>
                    <div class="form-group">
                        <label for="pw">Enter A Password:</label>
                        <input type="password" class="form-control" id="password" name="pw">
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <div align="center">
                    <button type="submit" class="btn btn-success" id="registerBtn" style="margin: auto;"> Register </button>
                </div>
                
            </div>
        </div>

    </div>
</div>
<!-- Login Modal -->
<div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <form action="http://www.eserv.us/login/" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox"> Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
        
HTML;

        $testing = <<< HTML

<header class="e-header">
    
    
    <!--<button type="button" class="e-header-toggle" data-toggle="collapse" data-target="#topNav, #sideNav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>-->
    <a class="header-btn" href="http://www.eserv.us">Underground Art School</a>
    
    <!-- Login Modal Trigger -->
    <a class="e-modal-button header-btn pull-right" data-toggle="e-modal" data-target="#loginModal">
        <i class="fa fa-sign-in" aria-hidden="true"></i>
        Login 
    </a>
    
    <!-- Register Modal Trigger -->
    <a class="e-modal-button header-btn pull-right" data-toggle="e-modal" data-target="#registerModal">
        <i class="fa fa-user-plus" aria-hidden="true"></i>
        Sign Up 
    </a>
    
    <div class="collapse " id="topNav">
        
        <!--<ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Navigate <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="http://www.eserv.us/blog/">Blog</a></li>
                    <li><a href="#">Forum</a></li>
                    <li><a href="#">Shop</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Become a Contributor!</a></li>
                </ul>
            </li>
        </ul>-->
        
        
    </div>

</header>


<!-- Register Modal -->
<div id="registerModal" class="e-modal" >
    <div class="e-modal-dialog">

        <!-- Modal content-->
        <div class="e-modal-content">
            <div class="e-modal-header">
                <button type="button" class="e-modal-close" data-target="#registerModal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <h3 class="e-modal-title"> Sign Up </h3>
            </div>
           
            
            <div class="e-modal-body">
                <div class="form-group">
                    <label for="email">
                        Enter Your Email Address:
                    </label>
                    <div id="emailLoader" style="display: inline-block;"></div>
                    <div id="validateEmail" class="error"></div>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="un">
                        Enter A Username:
                    </label>
                    <div id="usernameLoader" style="display: inline-block;"></div>
                    <div id="validateUsername" class="error"></div>
                    <input type="text" class="form-control" id="un" name="un">
                </div>
                <div class="form-group">
                    <label for="pw">
                        Enter A Password:
                    </label>
                    <span id="result"></span>
                    <div id="passwordLoader" style="display: inline-block;"></div>
                    <div id="validatePassword" class="error"></div>
                    <input type="password" class="form-control" id="pw" name="pw">
                </div>
                
            </div>
            <div class="e-modal-footer">
                <div align="center">
                    <button type="submit" class="btn btn-success" id="registerBtn" style="margin: auto;"> Register </button>
                </div>
                
            </div>
            
        </div>
    </div>
</div>


<!-- Login Modal -->
<div id="loginModal" class="e-modal">
    <div class="e-modal-dialog">

        <!-- Modal content-->
        <div class="e-modal-content">
            <div class="e-modal-header">
                <button type="button" class="e-modal-close" data-target="#loginModal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <h3 class="e-modal-title">Login</h3>
            </div>
            <form action="http://www.eserv.us/login/" method="POST">
                <div class="e-modal-body">
                
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <!--<div class="checkbox">
                        <input type="checkbox"> Remember me
                    </div>-->
                    
                
                </div>
                <div class="e-modal-footer">
                   
                    <div align="center">
                        <button type="submit" class="btn green">Submit</button>
                        
                    </div>
                    
                </div>
            </form>
        </div>

    </div>
</div>

HTML;


        echo $testing;
    }

}