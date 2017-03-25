<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/18/2017
 * Time: 2:10 PM
 */

namespace modules\contacts;


use framework\core\Authorize;
use framework\core\User;
use framework\libs\SessionManager;

class ContactsController {
    protected $USER;
    public function __construct() {
        $USER = new User();
        $this->USER = $USER->getUser(SessionManager::getSessionID());
    }

    public function createContactWidget() {
        if (Authorize::User($this->USER)) {
            $list = new ContactsWidget($this->USER);
        }
    }

    public function searchUsers($params) {
        if (Authorize::User($this->USER)) {
            $searchString = $_GET['string'];
            $search = new SearchUsers();
            $search = $search->search($this->USER, $searchString);
            echo $search;
        }
    }

    public function action($params) {
        $contactID = $_GET['contactID'];
        $action = $_GET['action'];

        //$worker = new ContactActions();
        //$worker->doAction($USER, $contactID, $action);
        $relation = new Relation($this->USER);

        $result = "";
        $contact = new User();
        $contact = $contact->getUser($contactID);

        // Process based on the action
        switch ($action) {
            case 'accept':
                $result = $relation->acceptFriendRequest($contact);
                break;
            case 'decline':
                $result = $relation->declineFriendRequest($contact);
                break;
            case 'cancel':
                $result = $relation->cancelFriendRequest($contact);
                break;
            case 'block':
                $result = $relation->block($contact);
                break;
            case 'unblock':
                $result = $relation->unblockFriend($contact);
                break;
            case 'add':
                $result = $relation->addFriendRequest($contact);
                break;
            case 'unfriend':
                $result = $relation->unfriend($contact);
                break;
        }
        echo $result;

    }

    public function getUpdates() {

    }
}