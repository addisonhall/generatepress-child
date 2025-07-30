/**
 * All the javascripts.
 * 
 * Some handy resources:
 * - @link iterating over nodeList: https://attacomsian.com/blog/javascript-loop-dom-elements
 */

/**
 * Stuff to do when everything is loaded
 */
window.addEventListener('load', () =>  {

    // Indicate when everything is loaded
    bodyLoaded();
    
    // Activate all prepped animations
    doScrollAnimations();

});

/**
 * Indicate when everything is loaded with body class
 */
const bodyLoaded = () => {
    var bodyEl = document.querySelector('body');
    bodyEl.classList.remove('preload');
    bodyEl.classList.add('loaded');
}

/**
 * Activate all prepped animations
 */
const prepAnimations = async () => {
    var animEls = document.querySelectorAll('.prep-animation');
    for (const animEl of animEls) {
        animEl.classList.remove('prep-animation');
        animEl.classList.add('do-animation');
    }
}

/**
 * Check to see if element is in view and animate
 */
const doScrollAnimations = async () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    await prepAnimations();
    
    const targets = document.querySelectorAll('.scroll-fade-in, .scroll-fade-in-left, .scroll-fade-in-bottom, .scroll-fade-in-right');
    
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (
                entry.isIntersecting &&
                (
                    entry.target.classList.contains('scroll-fade-in') ||
                    entry.target.classList.contains('scroll-fade-in-left') ||
                    entry.target.classList.contains('scroll-fade-in-bottom') ||
                    entry.target.classList.contains('scroll-fade-in-right')
                )
            ) {
                let modifier = '';
                if (entry.target.classList.contains('scroll-fade-in-left')) modifier = '-left';
                if (entry.target.classList.contains('scroll-fade-in-bottom')) modifier = '-bottom';
                if (entry.target.classList.contains('scroll-fade-in-right')) modifier = '-right';
                entry.target.classList.add('fade-in' + modifier, 'do-scroll-animation');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px 0px 0px'
    });
    
    targets.forEach(el => {
        observer.observe(el);
    });
}