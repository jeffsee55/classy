export default function() {
   jQuery(document).ready(function($){
       if($('.home-hero').length) {
           var windowHeight = $(window).height();
           var navHeight = $('nav.nav').height();
           var distance      = (windowHeight - navHeight);

           $('.home-hero').css('height', (distance) + 'px');
       }
   });
}
