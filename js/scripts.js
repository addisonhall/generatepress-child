/**
 * All the javascripts.
 * 
 * Some handy resources:
 * - @link iterating over nodeList: https://attacomsian.com/blog/javascript-loop-dom-elements
 */

/**
 * Indicate when everything is loaded with body class
 */
const bodyLoaded = () => {
    const bodyEl = document.querySelector('body');
    if (!bodyEl) {
        console.log('Where is the body element?');
        return;
    }
    bodyEl.classList.remove('preload');
    bodyEl.classList.add('loaded');
}

/**
 * Remove the redundant title attribute from the skip-to-content link
 */
const removeSkipToContentTitle = () => {
    const skipToContent = document.querySelector('a.skip-link');
    if (!skipToContent) return;
    skipToContent.removeAttribute('title');
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
 * Activate all prepped animations
 */
const prepAnimations = async () => {
    const animEls = document.querySelectorAll('.prep-animation');
    if (!animEls) return;
    animEls.forEach((animEl) => {
        animEl.classList.remove('prep-animation');
        animEl.classList.add('do-animation');
    });
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

/**
 * Extracts the YouTube video ID from a given URL.
 * Supports multiple YouTube URL formats.
 * 
 * @param {string} url - The YouTube URL.
 * @returns {string|null} - The video ID if found, otherwise null.
 */
const getYouTubeVideoID = (url) => {
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
 * Dynamic YouTube GP/GB overlay panel stuff
 * 
 * REMEMBER to replace 'gb-overlay-937' with the value of your overlay panel!
 */
const doYouTubeDynamicOverlay = () => {
	
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
 * Call functions and do stuff when everything is loaded
 */
window.addEventListener('load', () =>  {

    // Indicate when everything is loaded
    bodyLoaded();
    
    // Activate all prepped animations
    prepAnimations();

    // Make menus more accessible
    doAccessibleNavMenu();

    // Remove skip-to-content title
    removeSkipToContentTitle();

    // Check scroll animations
    checkScrollAnimations();
	
	// Check for dynamic YouTube overlay request
	doYouTubeDynamicOverlay();

});