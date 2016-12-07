/* global radiateScriptParam */
jQuery(document).ready(function() {

	if( radiateScriptParam.radiate_image_link === ''){
		var divheight = jQuery('.header-wrap').height()+'px';
		jQuery('body').css({ 'margin-top': divheight });
	}

	jQuery('.header-search-icon').click(function(){
		jQuery('#masthead .search-form').toggle('slow');
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
    // jQuery('.better-responsive-menu #site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <span class="genericon genericon-expand"></span> </span>');
    // jQuery('.better-responsive-menu #site-navigation .sub-toggle').click(function() {
    //     jQuery(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
    //     jQuery(this).children('<span class="genericon genericon-rightarrow"></span>').first().toggleClass('<span class="genericon genericon-expand"></span>');
    //     jQuery(this).toggleClass('active');
    // });
    jQuery('.better-responsive-menu  #site-navigation .menu-toggle').click(function() {
      jQuery('.better-responsive-menu  #site-navigation .menu').slideToggle('slow');
    });
});