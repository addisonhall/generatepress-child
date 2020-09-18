/**
 * All the javascripts.
 */

/**
 * Remove preload using the trick good ol' Chris taught us.
 * @link https://css-tricks.com/transitions-only-after-page-load/
 */
jQuery(window).load(function() {
    jQuery('body').removeClass('preload').addClass('loaded');
    
    // Activate all prepped animations
    jQuery('.prep-animation').removeClass('.prep-animation').addClass("do-animation");
});

jQuery(document).ready(function($) {

    /**
     * Scroll into view function courtesy of Scott Dowding
     * @link http://stackoverflow.com/questions/487073/check-if-element-is-visible-after-scrolling
     */

    // Check if element is scrolled into view
    function isScrolledIntoView(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();
        var elemOffsetTop = $(elem).offset().top;
        var elemHeight = $(elem).height()
        var elemTop = elemOffsetTop;
        var elemBottom = elemTop + elemHeight;
        return elemBottom <= docViewBottom && elemTop >= docViewTop;
    }

    /**
     * Trigger animations when element scrolls into view
     */
    $(window).scroll(function() {
        $(".scroll-fade-in-left").each(function() {
            if (isScrolledIntoView(this) === true) {
                $(this).addClass("fade-in-left do-scroll-animation");
            }
        });
        $(".scroll-fade-in").each(function() {
            if (isScrolledIntoView(this) === true) {
                $(this).addClass("fade-in do-scroll-animation");
            }
        });
        $(".scroll-fade-in-bottom").each(function() {
            if (isScrolledIntoView(this) === true) {
                $(this).addClass("fade-in-bottom do-scroll-animation");
            }
        });
        $(".scroll-fade-in-right").each(function() {
            if (isScrolledIntoView(this) === true) {
                $(this).addClass("fade-in-right do-scroll-animation");
            }
        });
    });
    
});