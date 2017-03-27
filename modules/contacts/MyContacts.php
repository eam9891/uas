<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/20/2017
 * Time: 7:02 PM
 */

namespace modules\contacts;


use framework\core\Authorize;
use framework\core\User;

class MyContacts {

    public function getContactList(User $USER, Relation $REL) : string {
        $returnRows = "";
        if (Authorize::User($USER)) {

            $myContacts = $REL->getFriendsList();

            if (!empty($myContacts)) {

                foreach ($myContacts as $rel) {

                    $color = "";
                    $active = "";
                    $friend = $REL->getFriend($rel);
                    $friendID = $friend->getUserId();
                    $activityTime = $friend->getActivityTime();
                    //$active = $friend->getActive();
                    // Current time - 15 minutes

                    $time = date("U");
                    $time -= (15 * 60);
                    $time = date("Y-m-d H:i:s", $time);

                    if($activityTime < $time) {
                        $isActive = 0;
                    } else {
                        $isActive = 1;
                    }

                    $friendUsername = $friend->getUsername();

                    switch ($isActive) {
                        // Todo: ??? How
                        case "2" :
                            $color = "orange";
                            $active = "Away";
                            break;
                        case "1" :
                            $color = "green";
                            $active = "Online";
                            break;
                        case "0" :
                            $color = "grey";
                            $active = "Offline";
                            break;
                    }

                    $status = <<<HTML
                
                <div class="centerTop">
                    <svg class="centerTop" width="17" height="17"> 
                        <circle cx="10" cy="10" r="6"  fill="$color" /> 
                    </svg>&nbsp
                    <span class="statusText"> $active </span>
                </div>
                
                        
HTML;

                    //$friendAvatar = $friend->getAvatar();

                    $returnRows .= <<<HTML

                <tr class="contact-row-container">
                    <td>
                        $status
                    </td>
                    <td class="contactActions">
                        <button class="btn btn-default  pull-right openChat" value="$friendID">
                            <span class="glyphicon glyphicon-envelope"></span>
                        </button>
                    </td>
                    <td>
                        <div class="contact-row">
                            <a href="" class="contactLink pull-right" style="color: #6D84B4;">
                                <span class="contactUsername">$friendUsername&nbsp</span>
                                <div class="avatar"></div>
                            </a> 
                        </div>
                    </td>
                </tr>           
                
HTML;

                }
            } else {
                $returnRows = '<h6>You don\'t have any friends yet!</h6>';
            }
        }
        return (string) $returnRows;
    }
}