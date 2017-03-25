<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/20/2017
 * Time: 6:26 PM
 */

namespace modules\contacts;


use framework\core\Authorize;
use framework\core\User;

class ContactActions {

    public function doAction(User &$USER, $contactID, $action) {
        if (Authorize::User($USER)) {
            $relation = new Relation($USER);

            $allowed_actions = array(
                'accept', // status to 1
                'decline', // status to 2
                'cancel', // delete relationship
                'block', // status 3
                'unblock', // delete relationship
                'add', // insert friend request
                'unfriend', // delete a friend
            );


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

        //$update = new ContactsWidget($USER);
        //return $update;


    }
}



