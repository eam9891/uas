<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/19/2017
 * Time: 11:45 PM
 */

namespace modules\chat;


use framework\core\User;

class ChatWriter {
    public function writeMessages(User $USER, $contactID, $messages) : string {
        $userID = (string) $USER->getUserId();

        $chat_converstaion = array();

        if (!empty($messages)) {

            foreach ($messages as $message) {

                $msg = htmlentities($message['message'], ENT_NOQUOTES);
                $user_name = $message['author'];
                $sent = date('F j, Y, g:i a', strtotime($message['messageDate']));
                $id = $message['id'];
                $messageUserID = $message['userID'];

                if ($messageUserID == $userID) {
                    $chat_converstaion[] = <<<HTML
        <tr class="msg-row-container" id="$id" >
            <td>
                <div class="msg-row">
                    <div class="avatar-left"></div>
                    <div class="message">
                        
                        <span class="user-label">
                            <a href="#" style="color: #6D84B4;">{$user_name}</a> 
                            <span class="msg-time">{$sent}</span>
                        </span><br/>{$msg}
                        
                    </div>
                </div>
            </td>
        </tr>
HTML;
                } else {
                    $chat_converstaion[] = <<<HTML
        <tr class="msg-row-container" id="$id" >
            <td>
                <div class="msg-row">
                    <div class="avatar-right"></div>
                    <div class="message">
                        
                        <span class="user-label">
                            <a href="#" style="color: #6D84B4;">{$user_name}</a> 
                            <span class="msg-time">{$sent}</span>
                        </span><br/>{$msg}
                        
                    </div>
                </div>
            </td>
        </tr>
HTML;
                }


            }

        }

        return implode('', $chat_converstaion);
    }
}