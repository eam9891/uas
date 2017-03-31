/**
 * Created by Ethan on 3/29/2017.
 */


$(document).ready(function(){

    var registerBtn = $('#registerBtn');
    var username    = $('input#un');

    var validateUsername = $('#validateUsername');


    // Search for users
    username.on('keydown', function() {
        var data = $(this).val();

        $(document).unbind(".mine");

        $.ajax({
            type: "POST",
            url: "http://www.eserv.us/register/validateUsername",
            data: {
                'string' : data
            },
            cache: false,
            dataType: 'json',
            success: function(data) {

                if (data['status'] == "green") {
                    username.css({'border' : '2px solid green'});
                } else {
                    username.css({'border' : '2px solid red'});
                }
                validateUsername.html(data['username']).fadeIn();
            }
        });
    });





});

