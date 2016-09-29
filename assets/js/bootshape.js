$(function() {
    $('.carousel').carousel('cycle');
});

$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});