<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/12/2017
 * Time: 1:14 PM
 */

namespace modules\blog;


use framework\core\Authorize;
use framework\core\User;
use framework\libs\SessionManager;
use modules\blog\admin\DeletePost;
use modules\blog\admin\EditBlog;
use modules\blog\admin\PublishPost;
use modules\blog\admin\RevertPost;
use modules\blog\contributor\EditPost;
use modules\blog\contributor\MyPosts;
use modules\blog\contributor\NewPost;
use modules\blog\contributor\SubmitEdits;
use modules\blog\contributor\SubmitPost;
use modules\home\HomeHead;
use modules\home\HomeHeader;

class BlogController {
    private $USER;
    private $params = [];
    public function __construct() {
        $this->USER = new User();
        $this->USER = $this->USER->getUser(SessionManager::getSessionID());

        if (!empty($_POST['params'])) {
            $this->params = $_POST['params'];
            unset($_POST['params']);
        }

    }

    public function default($params) {
        // Blog Front Page
        if (SessionManager::getSessionID()) {
            $head = new HomeHead($this->USER);
            $header = new HomeHeader($this->USER);
        } else {
            $head = new \IndexHead();
            $header = new \IndexHeader();
        }

        $body = new ViewBlog;
        $footer = new \IndexFooter();

    }

    public function viewPost($postTitle) {
        if (SessionManager::getSessionID()) {
            $head = new HomeHead($this->USER);
            $header = new HomeHeader($this->USER);
        } else {
            $head = new \IndexHead();
            $header = new \IndexHeader();
        }
        $worker = new ArticleFactory();
        $worker->getPost($postTitle);
        $footer = new \IndexFooter();
    }

    public function admin($params = []) {

        if (Authorize::AdminOnly($this->USER)) {

            switch ($params[0]) {
                case "editBlog" :
                    $worker = new EditBlog();
                    $worker->request($this->USER);
                    break;
                case "getEditTable" :
                    $worker = new ArticleFactory();
                    $worker->editBlog($this->params, $this->USER);
                    break;
                case "deletePost" :
                    $worker = new DeletePost();
                    $worker->deletePost($this->params, $this->USER);
                    break;
                case "publishPost" :
                    $worker = new PublishPost();
                    $worker->publishPost($this->params, $this->USER);
                    break;
                case "revertPost" :
                    $worker = new RevertPost();
                    $worker->revertPost($this->params, $this->USER);
                    break;
            }
        }
    }

    public function contributor($params = []) {

        if (Authorize::Contributor($this->USER)) {


            switch ($params[0]) {
                case "myPosts" :
                    $worker = new MyPosts();
                    $worker->getMyPosts($this->params, $this->USER);
                    break;
                case "editPost" :
                    $worker = new EditPost();
                    $worker->editPost($this->params, $this->USER);
                    break;
                case "submitEdit" :
                    $worker = new SubmitEdits();
                    $worker->submitEdits($this->params, $this->USER);
                    break;
                case "newPost" :
                    $worker = new NewPost();
                    $worker->newPost($this->USER);
                    break;
                case "submitPost" :
                    $postParams = $_GET['params'];
                    $worker = new SubmitPost();
                    $worker->submitPost($postParams, $this->USER);
                    break;

            }
        }
    }


}
