<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/4/2017
 * Time: 2:46 PM
 */

namespace modules\blog {

    use framework\core\User;
    use framework\core\Authorize;
    use framework\libs\SessionManager;

    class AdminWriter implements IArticleFactory {

        public function __construct(Article &$obj) {
            $USER = new User();
            $USER = $USER->getUser(SessionManager::getSessionID());
            if (Authorize::AdminOnly($USER)) {
                $this->write($obj);
            }
        }

        public function write(Article $obj) {

            $date = date('n/j/y', strtotime($obj->date));
            $time = date('h:i A', strtotime($obj->date));

            if ($obj->published) {
                $publishButton = <<<HTML
                    <button type='button' class='btn btn-default disabled'> Published </button>
                    <button type='button' class='btn btn-default btn-info revertPost' value='$obj->id'> Revert </button>
                
HTML;
            } else {
                $publishButton = <<<HTML

                    
                    <button type='button' class='btn btn-info publishPost' value='$obj->id'> Publish </button>
                
HTML;
            }


            echo <<<HTML
        
                <tr>
                    <td style="width: 120px; ">$obj->title</td>
                    <td>$date $time</td>
                    <td>$obj->author</td>
                    <td>
                        
                        <button value="$obj->id" class="btn btn-default btn-warning editPost"> Edit </button>
                        <button value="$obj->id" class="btn btn-default btn-danger deletePost"> Delete </button>
                        <input type="hidden" class="postPublished" name="postPublished" value="$obj->published">
                        $publishButton
                    </td>
                </tr>
                
              
             
HTML;



        }
    }
}