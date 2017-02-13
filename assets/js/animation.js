jQuery(document).ready(function($){
    window.sr = ScrollReveal();

    sr.reveal('.line-reveal h1', {
        distance: '30px',
        duration: 500,
        delay: 300,
        scale: 1,
        easing: 'ease-in-out'
    });

    sr.reveal('.line-reveal p', {
        distance: '-10px',
        duration: 500,
        delay: 500,
        scale: 1,
        easing: 'ease-in-out'
    });

    // var line = new Vivus('box-line', {
    //     animTimingFunction: Vivus.EASE_OUT,
    //     duration: 100
    // });
    // console.table(line.map);

});
