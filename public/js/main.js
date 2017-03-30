/**
 * Created by Ethan on 3/30/2017.
 */

function createModal(element) {
    var fullsize = $(element).data('toggle');
    var dataTarget = $(element).data('target');


    var targetAttr = $(dataTarget).fadeIn;

    $(dataTarget).css({'display' : 'block'});

}

function closeModal(element) {
    var close = $(element).data('target');
    $(close).css({'display' : 'none'});
}

$(document).ready(function(){
    var modal = $('.e-modal');

    $('.e-modal-button').click(function () {
        createModal(this);
    });

    $('.e-modal-close').click(function () {
        closeModal(this);
    });


});


