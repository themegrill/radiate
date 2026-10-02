/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );

	// Custom background: core rewrites the theme's background style element, but the theme paints #content.
	function radiateUpdateBackground() {
		var image = wp.customize( 'background_image' )();

		$( '#content' ).css( {
			'background-color'     : wp.customize( 'background_color' )() || '',
			'background-image'     : image ? 'url("' + image + '")' : 'none',
			'background-repeat'    : wp.customize( 'background_repeat' )(),
			'background-position'  : 'top ' + wp.customize( 'background_position_x' )(),
			'background-attachment': wp.customize( 'background_attachment' )()
		} );
	}

	$.each( [ 'color', 'image', 'repeat', 'position_x', 'attachment' ], function ( i, prop ) {
		wp.customize( 'background_' + prop, function ( value ) {
			value.bind( radiateUpdateBackground );
		} );
	} );
} )( jQuery );
