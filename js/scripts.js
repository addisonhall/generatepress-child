/**
 * All the javascripts.
 * 
 * Some handy resources:
 * - @link iterating over nodeList: https://attacomsian.com/blog/javascript-loop-dom-elements
 */

/**
 * Stuff to do when everything is loaded
 */
window.addEventListener('load', function()  {

    // Indicate when everything is loaded
    bodyLoaded();
    
    // Activate all prepped animations
    doAnimations();

    // Check scroll animations
    checkScrollAnimations();

});

/**
 * Do stuff on scroll
 */
window.onscroll = function() {
    
    // Check scroll animations
    checkScrollAnimations();
    
};

/**
 * Indicate when everything is loaded with body class
 */
function bodyLoaded() {
    var bodyEl = document.querySelector('body');
    bodyEl.classList.remove('preload');
    bodyEl.classList.add('loaded');
}

/**
 * Activate all prepped animations
 */
function doAnimations() {
    var animEls = document.querySelectorAll('.prep-animation');
    for (const animEl of animEls) {
        animEl.classList.remove('prep-animation');
        animEl.classList.add('do-animation');
    }
}

/**
 * Trigger animations when element scrolls into view
 */
function checkScrollAnimations() {
    var scrollLeftEls = document.querySelectorAll('.scroll-fade-in-left');
    for (const scrollLeftEl of scrollLeftEls) {
        if (isVisible(scrollLeftEl)) {
            scrollLeftEl.classList.add('fade-in-left', 'do-scroll-animation');
        }
    }

    var scrollFadeInEls = document.querySelectorAll('.scroll-fade-in');
    for (const scrollFadeInEl of scrollFadeInEls) {
        if (isVisible(scrollFadeInEl)) {
            scrollFadeInEl.classList.add('fade-in', 'do-scroll-animation');
        }
    }

    var scrollFadeBottomEls = document.querySelectorAll('.scroll-fade-in-bottom');
    for (const scrollFadeBottomEl of scrollFadeBottomEls) {
        if (isVisible(scrollFadeBottomEl)) {
            scrollFadeBottomEl.classList.add('fade-in-bottom', 'do-scroll-animation');
        }
    }

    var scrollFadeRightEls = document.querySelectorAll('.scroll-fade-in-right');
    for (const scrollFadeRightEl of scrollFadeRightEls) {
        if (isVisible(scrollFadeRightEl)) {
            scrollFadeRightEl.classList.add('fade-in-right', 'do-scroll-animation');
        }
    }
}

/**
 * Check to see if element is in view
 */
function isVisible (ele) {
    const { top, bottom } = ele.getBoundingClientRect();
    const vHeight = (window.innerHeight || document.documentElement.clientHeight);
    return ((top > 0 || bottom > 0) && top < vHeight);
}