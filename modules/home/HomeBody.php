<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/3/2017
 * Time: 2:44 PM
 */

namespace modules\home {

    use framework\core\Authorize;
    use framework\core\IUserInterface;
    use framework\core\User;


    class HomeBody extends IUserInterface {

        public function __construct(User &$USER) {
            parent::$auth = Authorize::User($USER);
            $username = $USER->getUsername();
            $role = $USER->getRole();
            self::$htmlString = <<<HTML

            <div class="container text-center">
                <div class="row">
                
                    <div class="col-md-3 well hidden-sm hidden-xs">
                        <div class="well">
                            <img src="http://www.eserv.us/public/images/img_avatar2.png" class="img-circle" height="65" width="65" alt="Avatar">
                            <p>
                                <a href="#">$username</a><br>
                                <small>$role</small>
                            </p>
                        </div>
                        <div class="well">
                            <p><a href="#">Interests</a></p>
                            <p>
                                <span class="label label-default">News</span>
                                <span class="label label-primary">W3Schools</span>
                                <span class="label label-success">Labels</span>
                                <span class="label label-info">Football</span>
                                <span class="label label-warning">Gaming</span>
                                <span class="label label-danger">Friends</span>
                            </p>
                        </div>
                        <div class="alert alert-success fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p><strong>Ey!</strong></p>
                            People are looking at your profile. Find out who.
                        </div>
                        <p><a href="#">Link</a></p>
                        <p><a href="#">Link</a></p>
                        <p><a href="#">Link</a></p>
                    </div>
                    
                    <div class="col-md-6 col-sm-9">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default text-left">
                                    <div class="panel-body">
                                        <p contenteditable="true">Status: Feeling Blue</p>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <span class="glyphicon glyphicon-thumbs-up"></span> Like
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="well">
                                    <p>John</p>
                                    <img src="bird.jpg" class="img-circle" height="55" width="55" alt="Avatar">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="well">
                                    <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="well">
                                    <p>Bo</p>
                                    <img src="bandmember.jpg" class="img-circle" height="55" width="55" alt="Avatar">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="well">
                                    <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-sm-3">
                                <div class="well">
                                    <p>Jane</p>
                                    <img src="bandmember.jpg" class="img-circle" height="55" width="55" alt="Avatar">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="well">
                                    <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="well">
                                    <p>Anja</p>
                                    <img src="bird.jpg" class="img-circle" height="55" width="55" alt="Avatar">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="well">
                                    <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 well">
                        <div class="thumbnail">
                            <p>Upcoming Events:</p>
                            <img src="paris.jpg" alt="Paris" width="400" height="300">
                            <p><strong>Paris</strong></p>
                            <p>Fri. 27 November 2015</p>
                            <button class="btn btn-primary">Info</button>
                        </div>
                        <div class="well">
                            <p>ADS</p>
                        </div>
                        <div class="well">
                            <p>ADS</p>
                        </div>
                    </div>
                </div>
            </div>
        
HTML;
            parent::__construct(self::$htmlString);
        }
    }
}