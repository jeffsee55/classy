import ScrollReveal from 'scrollreveal';

export default function () {
    window.sr = ScrollReveal();

    sr.reveal('.box', {
        distance: '30px',
        duration: 500,
        delay: 300,
        scale: 1,
        easing: 'ease-in-out'
    });
}
