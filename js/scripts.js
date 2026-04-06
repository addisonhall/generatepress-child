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

    // Make menus more accessible
    doAccessibleNavMenu();

    // Remove skip-to-content title
    removeSkipToContentTitle();

    // Check scroll animations
    checkScrollAnimations();
	
	// Check for dynamic YouTube overlay request
	doYouTubeDynamicOverlay();

});

/**
 * Extracts the YouTube video ID from a given URL.
 * Supports multiple YouTube URL formats.
 * 
 * @param {string} url - The YouTube URL.
 * @returns {string|null} - The video ID if found, otherwise null.
 */
function getYouTubeVideoID(url) {
    if (typeof url !== "string" || !url.trim()) {
        console.error("Invalid input: URL must be a non-empty string.");
        return null;
    }

    try {
        // Ensure it's a valid URL
        const parsedUrl = new URL(url);

        // Case 1: Standard watch URL
        if (parsedUrl.hostname.includes("youtube.com")) {
            if (parsedUrl.searchParams.has("v")) {
                return parsedUrl.searchParams.get("v");
            }

            // Case 2: Embed or Shorts format
            const pathParts = parsedUrl.pathname.split("/");
            const possibleID = pathParts[pathParts.length - 1];
            if (possibleID && possibleID.length >= 11) {
                return possibleID;
            }
        }

        // Case 3: Shortened youtu.be URL
        if (parsedUrl.hostname === "youtu.be") {
            const id = parsedUrl.pathname.slice(1);
            if (id && id.length >= 11) {
                return id;
            }
        }

        return null; // No valid ID found
    } catch (e) {
        console.error("Invalid URL format:", e.message);
        return null;
    }
}

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

/**
 * Dynamic YouTube GP/GB overlay panel stuff
 * 
 * REMEMBER to replace 'gb-overlay-937' with the value of your overlay panel!
 */
function doYouTubeDynamicOverlay() {
	
	// check for presence of YT overlay
	const youtubeOverlay = document.getElementById('gb-overlay-937');
	
	// check for overlay button triggers
	const buttons = document.querySelectorAll('[data-gb-overlay="gb-overlay-937"]');
	
	// bail out if required elements aren't present
	if (!buttons) return;	
	
	// watch for button clicks and load requested videos accordingly
	buttons.forEach(function(button) {
		button.addEventListener('click', function(e) {
			let videoUrl = 'https://www.youtube.com/embed/' + getYouTubeVideoID(e.target.href) + '?feature=oembed&amp;autoplay=1';
			let iframe = youtubeOverlay.querySelector('iframe');
			iframe.setAttribute('src', videoUrl);
		})
	})
}

/**
 * Manipulate the main menu to be more accessible
 */
const doAccessibleNavMenu = () => {
    const menuLinksRoleButton = document.querySelectorAll('.menu .menu-item.is-role-button > a');
    if (!menuLinksRoleButton) return;
    menuLinksRoleButton.forEach((menuItem) => {
        let linkHref = menuItem.dataset.href;
        menuItem.addEventListener('click', function(event) {
            event.preventDefault();
            location.href = linkHref;
        })
    });
}

/**
 * Remove the redundant title attribute from the skip-to-content link
 */
const removeSkipToContentTitle = () => {
    const skipToContent = document.querySelector('a.skip-link');
    if (!skipToContent) return;
    skipToContent.removeAttribute('title');
}