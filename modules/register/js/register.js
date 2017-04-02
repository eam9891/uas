/**
 * Created by Ethan on 3/29/2017.
 */

function registerLoader(div) {

    $('#' + div).css("display", "inline-block");

    $(document).bind("ajaxStop.mine", function() {
        //$('#' + div).css("display", "none");

    });

}

$(document).ready(function(){

    var registerBtn = $('#registerBtn');
    var email       = $('input#email');
    var username    = $('input#un');
    var password    = $('input#pw');
    var timeout     = null;

    var validateEmail    = $('#validateEmail');
    var validateUsername = $('#validateUsername');
    var validatePassword = $('#validatePass');

    // Validate Email
    email.on('keydown', function() {
        clearTimeout(timeout);

        $('#emailLoader').html("<img src='http://www.eserv.us/public/images/rollingRed.gif'>");
        $(document).unbind(".mine");
        registerLoader('emailLoader');

        timeout = setTimeout(function(){

            var em = email.val();

            $.ajax({
                type: "POST",
                url: "http://www.eserv.us/register/validateEmail",
                data: {
                    'em' : em
                },
                cache: false,
                dataType: 'json',
                success: function(data) {

                    if (data['status'] === "green") {
                        email.css({'border' : '2px solid green'});
                        $('#emailLoader').html("<img src='http://www.eserv.us/public/images/check.png' style='width: 18px; height: 18px;'>")
                    } else {
                        email.css({'border' : '2px solid red'});
                        $('#emailLoader').html("<img src='http://www.eserv.us/public/images/nahSign.png' style='width: 18px; height: 18px;'>")
                    }
                    validateEmail.html(data['msg']).fadeIn();
                }
            });
        }, 500);

    });



    // Validate Username
    username.on('keydown', function() {
        clearTimeout(timeout);

        $('#usernameLoader').html("<img src='http://www.eserv.us/public/images/rollingRed.gif'>");
        $(document).unbind(".mine");
        registerLoader('usernameLoader');

        timeout = setTimeout(function(){

            var un = username.val();

            $.ajax({
                type: "POST",
                url: "http://www.eserv.us/register/validateUsername",
                data: {
                    'un' : un
                },
                cache: false,
                dataType: 'json',
                success: function(data) {

                    if (data['status'] === "green") {
                        username.css({'border' : '2px solid green'});
                        $('#usernameLoader').html("<img src='http://www.eserv.us/public/images/check.png' style='width: 18px; height: 18px;'>")
                    } else {
                        username.css({'border' : '2px solid red'});
                        $('#usernameLoader').html("<img src='http://www.eserv.us/public/images/nahSign.png' style='width: 18px; height: 18px;'>")
                    }
                    validateUsername.html(data['msg']).fadeIn();
                }
            });
        }, 500);

    });


    registerBtn.on('click', function () {

        $(document).unbind(".mine");
        var un = username.val();
        var pw = password.val();
        var em = email.val();
        $.ajax({
            type: "POST",
            url: "http://www.eserv.us/register/",
            data: {
                'un' : un,
                'pw' : pw,
                'em' : em
            },
            cache: false,
            success: function(data) {
                $('.e-modal-content').html(data);
            }
        });

    });


});

