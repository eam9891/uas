<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/22/2017
 * Time: 11:06 PM
 */

namespace modules\contacts;


use framework\core\Authorize;
use framework\core\User;
use framework\database\Database;

class SearchUsers {


    public function search(User &$USER, $searchString) {
        $returnString = "";
        if (Authorize::User($USER)) {
            $REL = new Relation($USER);
            $query = "SELECT userID, username, avatar FROM users WHERE username LIKE '%{$searchString}%' ";
            $stmt = Database::query($query);
            $myContacts = $REL->getFriendsList();


            if ($stmt->rowCount() == 0) {
                $returnString = "<tr class='contact-row-container'><td>Ah snap... No Results Found!</td></tr>";
            } else {
                // Lo0p through the results
                while($row = $stmt->fetch()) {
                    $button = "";
                    $username = $row['username'];
                    $userID = $row['userID'];
                    $status = "notFriends";

                    // Loop through friends
                    foreach ($myContacts as $myContact) {
                        $friend = $REL->getFriend($myContact);
                        $friendID = $friend->getUserId();


                        if ($userID == $friendID) {
                            $status = "friends";
                        }
                    }


                    switch ($status) {
                        case "friends" :
                            $button = <<<HTML

                <button class="btn btn-default disabled">
                    Already Added
                   
                </button>   
                
HTML;
                            break;
                        case "notFriends" :
                            $button = <<<HTML

                <button class="btn btn-success sendRequest" value="$userID">
                    Send Request
                    <span class="glyphicon glyphicon-plus"></span>
                </button>   
                
HTML;
                            break;
                        case "requestSent" :

                            break;
                        case "blocked" :



                    }

                    $returnString .=  <<<HTML

                <tr class="contact-row-container">
                    <td>
                        <div class="avatar"></div>
                    </td>
                    <td>
                       <a href="" class="contactLink" style="color: #6D84B4;">
                            <span class="contactUsername">$username&nbsp</span>
                        </a> 
                    </td>
                    <td class="contactActions">
                        $button
                    </td>
                    
                </tr>           
                
HTML;
                }
            }
        }
        return $returnString;
    }
}