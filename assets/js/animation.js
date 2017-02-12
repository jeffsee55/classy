jQuery(document).ready(function($){
    window.sr = ScrollReveal();

    sr.reveal('.line-reveal h1', {
        distance: '50px',
        duration: 400,
        delay: 300,
        scale: 1,
        easing: 'ease-in-out'
    });

    sr.reveal('.line-reveal p', {
        distance: '-10px',
        duration: 300,
        delay: 500,
        scale: 1,
        easing: 'ease-in-out'
    });

    new Vivus('box-line', {
        duration: 50,
        animTimingFunction: Vivus.EASE_OUT
    });
});
