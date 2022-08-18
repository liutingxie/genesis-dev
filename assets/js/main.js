/**
 * Add any custom theme JavaScript to this file.
 */
( function( $ ) {

	$( '.site-footer .enews form' ).append( '<span class="send-icon"></span>' );
	$( '.sidebar .enews form' ).append( '<span class="send-icon"></span>' );

	/*
	 * Move before header into nav on mobile.
	 */
	$( window ).on( "resize", function () {
		if ( $( window ).width() < 896 ) {
			$( '.header-widget-area' ).appendTo( '.nav-primary .menu' );
		} else {
			$( '.header-widget-area' ).appendTo( '.site-header .wrap' );
			$( '.nav-primary .menu .header-widget-area' ).remove();
		}
	} ).resize();

})( jQuery );



