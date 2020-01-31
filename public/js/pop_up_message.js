$(document).ready(function () {

    var pop_message =  $(".pop_message");
    var navbar = $(".navbar");
    var currentheight = parseInt(navbar.css("padding-top"), 10 );
    var addheight = pop_message.height() +  currentheight;
    if (pop_message.text() !== '') {
        navbar.css("padding-top", addheight);
        pop_message.show('slow');
        setTimeout(function () {
            pop_message.hide('slow');
            navbar.css("padding-top", currentheight);
        }, 3000);
    }
})