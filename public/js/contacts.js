/**
 * Created by Ethan on 3/18/2017.
 */

eChat = {
    interval : 0,
    friendID : 1,
    intervals : Array,
    setMsgInterval : function(interval) {
        this.interval = interval;
    },
    bootChat: function(chatID) {
        eChat.friendID = chatID;
        //eChat.iDs.push(chatID);

        this.startDaemon();
    },
    startDaemon : function() {
        this.daemon = setInterval(this.getMessages, this.interval);
    },
    stopDaemon : function () {
        this.interval = 0;
        clearInterval(this.daemon);
    },

    getMessages: function() {

        var id = eChat.friendID;
        var mId = $('#msgs tbody tr:last').attr('id');
        $(document).unbind(".mine");
        $.ajax({
            url: "http://192.168.0.132/mvc/chat/getMessages/",
            method: 'GET',
            data: {
                'chatID' : id,
                'lmID' : mId
            },
            success: function(data) {
                $('.chatBox#' + id + ' #msgs tbody').append(data).fadeIn();

            }
        });
    }

};



function activateTab(whichTab){
    $('.nav-tabs a[href="#' + whichTab + '"]').tab('show');
}

$(document).ready(function(){
    var openChat = $('td.contactActions button.openChat');
    var chatBoxes = $('#chatBoxes');
    var acceptRequest = $('.acceptRequest');
    var cancelRequest = $('.cancelRequest');
    var openContacts = $('#openContacts');
    var openMessages = $('#openMessages');
    var openRequests = $('#openRequests');
    var contactWidget = $('#contactWidget');
    var searchResults = $('table#searchResults tbody');
    var intervals = [];

    openContacts.on('click', activateTab("home"));

    acceptRequest.on('click', function () {
        // Unbind the loader, todo make a new loader for the chat
        $(document).unbind(".mine");
        var data = {
            "contactID" : $(this).val(),
            "action" : "accept"
        };
        // Get the new chat box window
        $.ajax({
            type: "GET",
            url: "http://192.168.0.132/mvc/contacts/action/",
            data: data,
            success: function(data) {
                chatBoxes.append(data).fadeIn();
            }
        });
    });

    // Open a chat
    openChat.on('click' , function(){
        var chatID = $(this).val();

        // Unbind the loader, todo make a new loader for the chat
        $(document).unbind(".mine");

        // Get the new chat box window
        $.ajax({
            type: "POST",
            url: "http://192.168.0.132/mvc/chat/getChatWidget/" + chatID,
            cache: false,
            success: function(data) {
                chatBoxes.append(data).fadeIn();


                // Set the default interval for getting messages
                eChat.setMsgInterval(5000);
                // Initialize the chat
                eChat.bootChat(chatID);
                $(".message-area").scrollTop($(".message-area").prop("scrollHeight"));

            }
        });



    });

    // Close the chat, and stop gathering messages
    chatBoxes.on('click', '.chatMsgClose', function() {
        var chatID = $(this).val();
        clearInterval(chatID);
        eChat.stopDaemon();
        //var chat = intervals[chatID];
        //delete intervals[chatID];
        //clearInterval(chat);
        $(this).parent().parent().parent().remove();
    });

    // Submit a message
    chatBoxes.on('keydown', '#input', function(event) {
        var chatID = $(this).parent().parent().attr("id");
        var msg = $(this).val();
        var msgArea = $('#' + chatID + ' > #msgs');

        // If event = enter button pressed
        if (event.keyCode == 13) {
            $(document).unbind(".mine");


            $(this).val('');

            $.ajax({
                type: "POST",
                url: "http://192.168.0.132/mvc/chat/addMessage/" + chatID,
                data: {
                    'msg'  : msg
                },
                cache: false,
                success: function(data) {

                    msgArea.append(data).fadeIn();

                    msgArea.scrollTop(msgArea.prop("scrollHeight"));
                }
            });

        }

    });

    // Search for users
    contactWidget.on('keydown', '#searchUsers', function() {
        var data = $(this).val();

        $(document).unbind(".mine");

        $.ajax({
            type: "GET",
            url: "http://192.168.0.132/mvc/contacts/searchUsers/",
            data: {
                'string' : data
            },
            cache: false,
            success: function(data) {
                searchResults.html(data).fadeIn();
            }
        });

    });

    // Send friend request from search
    contactWidget.on('click', 'button.sendRequest', function () {
        var data = $(this).val();

        $(document).unbind(".mine");

        $.ajax({
            type: "GET",
            url: "http://192.168.0.132/mvc/contacts/action/",
            data: {
                'contactID' : data,
                'action'    : "add"
            },
            success: function(data) {
                searchResults.hide().html(data).fadeIn();

            }
        });
    })
});

