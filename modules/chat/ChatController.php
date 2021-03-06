<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/18/2017
 * Time: 10:54 AM
 */

namespace modules\chat;


use framework\core\Authorize;
use framework\core\User;
use framework\libs\SessionManager;

class ChatController {
    protected $USER, $userID, $chatWriter;
    public function __construct() {
        $USER = new User();
        $this->USER = $USER->getUser(SessionManager::getSessionID());
        $this->userID = $this->USER->getUserId();
    }

    public function getChatWidget($params) {
        if (Authorize::User($this->USER)) {

            //Notice: Uninitialized string offset: 0 in /var/www/eserv.us/public_html/modules/chat/ChatController.php on line 27
//Failed to run query: SQLSTATE[42000]: Syntax error or access violation: 1064

            $contactID = $params[0];
            $chat = new FbChatMock();
            $messages = $chat->getAllMessages($this->USER, $contactID);

            $chatWriter = new ChatWriter();
            $returnMsgs = $chatWriter->writeMessages($this->USER, $contactID, $messages);

            $chatWidget = new ChatWidget();
            $chatWidget = $chatWidget->createChatWidget($this->USER, $contactID, $returnMsgs);
            echo $chatWidget;


        }
    }

    public function getMessageUpdates() {

    }

    public function messagesRead($contactID) {
        if (Authorize::User($this->USER)) {
            $contactID = $contactID[0];
            $chat = new FbChatMock();
            $chat->updateMessageRead($this->userID, $contactID);

        }
    }

    public function getMessages($params) {
        if (Authorize::User($this->USER)) {

            $contactID = $_GET['chatID'];
            $lastMsgID = $_GET['lmID'];



            $chat = new FbChatMock();
            $messages = $chat->getChatUpdates($this->userID, $contactID, $lastMsgID);

            $returnMsgs = new ChatWriter();
            $newMsgs = $returnMsgs->writeMessages($this->USER, $contactID, $messages);
            echo $newMsgs;
        }
    }

    public function addMessage($params) {
        if (isset($_POST['msg'])) {
            $friendID = $params[0];

            // Escape the message string
            $msg = htmlentities($_POST['msg'],  ENT_NOQUOTES);

            $chat = new FbChatMock();
            $chat->addMessage($this->USER, $msg, $friendID);

        } else {
            echo "No message is set!";
        }

    }
}