/**
 * Created by Ethan on 3/24/2017.
 */

function loader() {
    $(document).bind("ajaxStart.mine", function() {
        $("#wait").css("display", "block");
    });

    $(document).bind("ajaxStop.mine", function() {
        $("#wait").css("display", "none");
    });


}



var data;
$.ajax({
    type: "POST",
    url: "blog/admin/editBlog/",
    data: {"params":{"orderBy":"postID","whichOrder":"DESC"}},
    success : function(data) {
        $("#display").hide().html(data).fadeIn();
    }
});




$(document).ready(function() {


    $('#blogToolsButton').on('click' , function(){
        $('#blogToolsArrow').toggleClass('glyphicon-chevron-down').toggleClass('glyphicon-chevron-right');
    });

    $('#userMenuButton').on('click' , function(){
        $('#userMenuArrow').toggleClass('glyphicon-chevron-down').toggleClass('glyphicon-chevron-right');
    });

    $('#userToolsButton').on('click' , function(){
        $('#userToolsArrow').toggleClass('glyphicon-chevron-right').toggleClass('glyphicon-chevron-down');
    });



    $('#editBlog').on('click' , function(){
        loader();
        var data;
        $.ajax({
            type: "POST",
            url: "blog/admin/editBlog/",
            data: {"params":{"orderBy":"postID","whichOrder":"DESC"}},
            success : function(data) {
                $("#display").hide().html(data).fadeIn();
            }
        });
        return false;
    });


    $('#showBlog').on('click' , function(){
        loader();
        var data;
        $.ajax({
            type: "POST",
            url: "blog/",
            data: [],
            success : function(data) {
                $("#display").hide().html(data).fadeIn();
            }
        });
        return false;
    });


    $('#newPost').on('click' , function(){
        loader();
        var data;
        $.ajax({
            type: "POST",
            url: "blog/contributor/newPost",
            data: {"userID":"1","username":"e"},
            success : function(data) {
                $("#display").hide().html(data).fadeIn();
            }
        });
        return false;
    });



});