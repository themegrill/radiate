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

	// Primary color option
	wp.customize( 'radiate_color_scheme', function ( value ) {
			console.log( 'chalyo' );
		value.bind( function ( primaryColor ) {
			// Store internal style for primary color
			var primaryColorStyle = '<style id="radiate-internal-primary-color"> blockquote{border-color:#EAEAEA #EAEAEA #EAEAEA ' + primaryColor + '}' +
			'.site-title a:hover,a{color:' + primaryColor + '}' +
			'#masthead .search-form,.main-navigation a:hover,.main-navigation ul li ul li a:hover,' +
			'.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,' +
			'.main-navigation ul li.current-menu-item a,.main-navigation ul li.current-menu-item ul li a:hover,' +
			'.main-navigation ul li.current_page_ancestor a,.main-navigation ul li.current_page_item a,' +
			'.main-navigation ul li:hover>a{background-color:' + primaryColor + '}' +
			'.header-search-icon:before{color:' + primaryColor + '}' +
			'button,input[type=button],input[type=reset],input[type=submit]{background-color:' + primaryColor + '}' +
			'#content .comments-area a.comment-edit-link:hover,#content .comments-area a.comment-permalink:hover,' +
			'#content .comments-area article header cite a:hover,#content .entry-meta span a:hover,' +
			'#content .entry-title a:hover,.comment .comment-reply-link:hover,.comments-area .comment-author-link a:hover,' +
			'.entry-meta span:hover,.site-header .menu-toggle,.site-header .menu-toggle:hover{color:' + primaryColor + '}' +
			'.main-small-navigation ul li ul li a:hover,.main-small-navigation ul li:hover,' +
			'.main-small-navigation ul li a:hover,.main-small-navigation ul li ul li:hover>a,' +
			'.main-small-navigation ul > .current_page_item, .main-small-navigation ul > .current-menu-item,' +
			'.main-small-navigation ul li.current-menu-item ul li a:hover{background-color:' + primaryColor + '}' +
			'#featured_pages a.more-link:hover{border-color:' + primaryColor + ';color:' + primaryColor + '}' +
			'a#back-top:before{background-color:' + primaryColor + '}a#scroll-up span{color:' + primaryColor + '}' +
			'.woocommerce ul.products li.product .onsale,.woocommerce span.onsale,' +
			'.woocommerce #respond input#submit:hover, .woocommerce a.button:hover,' +
			'.wocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover,' +
			'.woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {background-color: ' + primaryColor + '}' +
			'.woocommerce .woocommerce-message::before { color: ' + primaryColor + '; }' +
			'.main-small-navigation ul li ul li.current-menu-item > a { background: ' + primaryColor + '; }</style>';

			// Remove previously create internal style and add new one.
			$( 'head #radiate-internal-primary-color' ).remove();
			$( 'head' ).append( primaryColorStyle );
		}
		);
	} );
} )( jQuery );
