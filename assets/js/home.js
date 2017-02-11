jQuery(document).ready(function($){
    var windowHeight = $(window).height();
    var scrollTop     = $(window).scrollTop();
    var elementOffset = $('.home-hero').offset().top;
    var distance      = (elementOffset - scrollTop);

    $('.home-hero').css('min-height', (windowHeight - distance) + 'px');
});
