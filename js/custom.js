/* global radiateScriptParam */
jQuery(document).ready(function() {

	if( radiateScriptParam.radiate_image_link === ''){
		var divheight = jQuery('.header-wrap').height()+'px';
		jQuery('body').css({ 'margin-top': divheight });
	}

	var hideSearchForm = function() {
		jQuery( '#masthead .search-form' ).hide( 'slow' );
	};
	jQuery('.header-search-icon').click(function(){
		jQuery('#masthead .search-form').toggle('slow');

		// focus after some time to fix conflict with toggleClass
		setTimeout( function () {
			jQuery( '#masthead .search-form input' ).focus();
		}, 200 );

		// For esc key press.
		jQuery( document ).on( 'keyup', function ( e ) {

			// on esc key press.
			if ( 27 === e.keyCode ) {
				// if search box is opened
				if ( jQuery( '#masthead' ).has( '.search-form' ) ) {
					hideSearchForm();
				}

			}
		} );

		jQuery( document ).on( 'click', function( e ) {
			var container = jQuery( '.search-form, .header-search-icon, .search-form input' );
			if ( ! container.is( e.target ) ) {
				hideSearchForm();
			}

		} );

	});

	jQuery(window).bind('scroll', function() {
		header_image_effect();
	});

   // Scroll to top
   jQuery('#scroll-up').hide();
   jQuery(function () {
      jQuery(window).scroll(function () {
         if (jQuery(this).scrollTop() > 1000) {
            jQuery('#scroll-up').fadeIn();
         } else {
            jQuery('#scroll-up').fadeOut();
         }
      });
      jQuery('a#scroll-up').click(function () {
         jQuery('body,html').animate({
            scrollTop: 0
         }, 800);
         return false;
      });
   });

});


function header_image_effect() {
	var scrollPosition = jQuery(window).scrollTop();
	jQuery('#parallax-bg').css('top', (0 - (scrollPosition * 0.2)) + 'px');
}

jQuery(document).ready(function() {
    jQuery('.better-responsive-menu  #site-navigation .menu-toggle').click(function() {
      jQuery('.better-responsive-menu  #site-navigation .menu-primary-container > ul,.better-responsive-menu  #site-navigation .menu > ul').slideToggle('slow');
    });
});
