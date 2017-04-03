/**
 * Created by Ethan on 3/29/2017.
 */

function registerLoader(div) {

    $('#' + div).css("display", "inline-block");

    $(document).bind("ajaxStop.mine", function() {
        //$('#' + div).css("display", "none");

    });

}

function checkStrength(password) {
    //initial strength
    var strength = 0

    //if the password length is less than 6, return message.
    if (password.length < 6) {
        $('#result').removeClass();
        $('#result').addClass('short');
        return 'Too short'
    }

    //length is ok, lets continue.

    //if length is 8 characters or more, increase strength value
    if (password.length > 7) strength += 1;

    //if password contains both lower and uppercase characters, increase strength value
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1;

    //if it has numbers and characters, increase strength value
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1;

    //if it has one special character, increase strength value
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1;

    //if it has two special characters, increase strength value
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;

    //now we have calculated strength value, we can return messages

    //if value is less than 2
    if (strength < 2) {
        $('#result').removeClass();
        $('#result').addClass('weak');
        return 'Weak'
    }
    else if (strength == 2 )
    {
        $('#result').removeClass()
        $('#result').addClass('good')
        return 'Good'
    }
    else
    {
        $('#result').removeClass()
        $('#result').addClass('strong')
        return 'Strong'
    }
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

    // Validate Password
    password.on('keydown', function() {
        clearTimeout(timeout);

        $('#passwordLoader').html("<img src='http://www.eserv.us/public/images/rollingRed.gif'>");
        $(document).unbind(".mine");
        registerLoader('passwordLoader');

        timeout = setTimeout(function() {

            $('#result').html(checkStrength(password.val()));

            var pw = password.val();

            $.ajax({
                type: "POST",
                url: "http://www.eserv.us/register/validatePassword",
                data: {
                    'pw' : pw
                },
                cache: false,
                dataType: 'json',
                success: function(data) {

                    if (data['status'] === "green") {
                        password.css({'border' : '2px solid green'});
                        $('#passwordLoader').html("<img src='http://www.eserv.us/public/images/check.png' style='width: 18px; height: 18px;'>")
                    } else {
                        password.css({'border' : '2px solid red'});
                        $('#passwordLoader').html("<img src='http://www.eserv.us/public/images/nahSign.png' style='width: 18px; height: 18px;'>")
                    }
                    validatePassword.html(data['msg']).fadeIn();
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

