<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/18/2017
 * Time: 3:20 AM
 */

namespace modules\chat;


use framework\core\Authorize;
use framework\core\User;

class ChatWidget {


    public function createChatWidget(User $USER, int $friendID, string $chatMessages) : string{
        if (Authorize::User($USER)) {
            $chatWidget = $this->constructChatUI($friendID, $chatMessages);
            return $chatWidget;
        }
    }

    private function constructChatUI(int $friendID, string $chatMessages) : string {
        $friend = new User();
        $friend = $friend->getUser($friendID);
        $friendUsername = $friend->getUsername();

        $chatWidget = <<<HTML



<div class="chatBox open" id="$friendID">
    <header>
        <div class="status"></div>
        <div class="header-text">
            $friendUsername
            <button id="$friendID" class="chatMsgClose chatBtn glyphicon glyphicon-remove"></button>
            <button id="chatMsgMinimize" data-toggle="collapse" data-target=".msgCollapse" class="chatBtn glyphicon glyphicon-chevron-down"></button>
        </div>
    </header>
    <div class="msgCollapse collapse in message-area">
        <table class="table table-responsive" id="msgs">
            $chatMessages
        </table>
    </div>
    <div class="input-area msg-wgt-footer msgCollapse collapse in" >
        <input type="text" id="input" placeholder="Type your message:        Press Enter to Send." />
    </div>
</div>

<script>
    $('#chatMsgMinimize').on('click' , function(){
        $(this).toggleClass('glyphicon-chevron-down').toggleClass('glyphicon-chevron-up');
    });
    
    
    $('.msgContainer').on('click' , function(){
    var value = $('#chatID').val();
    $.ajax({
        type: "POST",
        url: "http://192.168.0.132/mvc/chat/messagesRead/" + value,
        cache: false,
        success: function(data) {
            

        }
    });
});
    
</script>  


HTML;
        return $chatWidget;
    }

}