/**
 * Created by Ethan on 3/29/2017.
 */
function loader() {
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    });
}