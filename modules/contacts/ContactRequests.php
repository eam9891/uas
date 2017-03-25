<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/19/2017
 * Time: 12:30 AM
 */

namespace modules\contacts;


class ContactRequests {
    public function sentRequests(Relation $relation) : string {
        // Holds the list of Friend requests sent
        $sentRequests = $relation->getSentFriendRequests();
        $returnString = "";
        if (!empty($sentRequests)) {
            foreach ($sentRequests as $rel) {
                $contact = $relation->getFriend($rel);
                $contactID = $contact->getUserId();
                $contactName = $contact->getUsername();
                $returnString .= <<<sentRequests


<tr class="contact-row-container">
    <td>
        <div class="avatar pull-left"></div>
        <a class="contactLink" href="profile.php?uid=$contactID"> $contactName </a></li>
    </td>
    <td>
        <button class="btn btn-danger cancelRequest" title="Cancel Request" value="$contactID"> 
            Cancel 
        </button>
    </td>
</tr>          
                
sentRequests;

            }

        } else {
            $returnString = '<h6>No friend requests sent!</h6>';
        }
        return $returnString;
    }

    public function getRequests(Relation $relation) : string {
        // Holds the list of friend requests for user
        $user_friend_requests = $relation->getFriendRequests();
        $returnString = "";
        if (!empty($user_friend_requests)) {
            foreach ($user_friend_requests as $rel) {
                $contact = $relation->getFriend($rel);
                $contactID = $contact->getUserId();
                $contactName = $contact->getUsername();
                $returnString .= <<<getRequests
                
<tr class="contact-row-container">
    <td>
        <div class="avatar pull-left"></div>
        <a class="contactLink" href="profile.php?uid=$contactID"> $contactName </a></li>
    </td>
    <td>
        <button class="btn btn-success acceptRequest" value="$contactID" title="Accept">
            Accept
        </button>
    </td>
    <td>
        <a class="btn btn-danger" href="user_action.php?action=decline&friend_id=$contactID">
            Decline
        </a>
    </td>
</tr>        
                

getRequests;


            }

        } else {
            $returnString = '<h6>No friend requests!</h6>';
        }
        return $returnString;
    }
}