/**
 * Heart Curve Shortcode
 * Rasterizes the implicit curve (x^2 + y^2 - 1)^3 - x^2*y^3 = 0
 * and fills the interior region (where f(x,y) <= 0) solid.
 */
( function () {
	'use strict';

	function hexToRgb( hex ) {
		hex = hex.replace( '#', '' );
		if ( hex.length === 3 ) {
			hex = hex
				.split( '' )
				.map( function ( c ) {
					return c + c;
				} )
				.join( '' );
		}
		var num = parseInt( hex, 16 );
		if ( isNaN( num ) ) {
			// Fallback red if an unparseable value (e.g. named color) was supplied.
			return { r: 230, g: 0, b: 0 };
		}
		return {
			r: ( num >> 16 ) & 255,
			g: ( num >> 8 ) & 255,
			b: num & 255,
		};
	}

	function drawHeart( canvas ) {
		var ctx = canvas.getContext( '2d' );
		var w = canvas.width;
		var h = canvas.height;
		var range = parseFloat( canvas.getAttribute( 'data-range' ) ) || 1.6;
		var colorAttr = canvas.getAttribute( 'data-color' ) || '#e60000';
		var rgb = hexToRgb( colorAttr );

		var img = ctx.createImageData( w, h );
		var data = img.data;

		for ( var j = 0; j < h; j++ ) {
			// Flip y so the curve isn't upside down (canvas y grows downward).
			var y = range - ( 2 * range * j ) / ( h - 1 );
			var yy = y * y;

			for ( var i = 0; i < w; i++ ) {
				var x = -range + ( 2 * range * i ) / ( w - 1 );
				var xx = x * x;

				var t = xx + yy - 1;
				var f = t * t * t - xx * y * yy; // (x^2+y^2-1)^3 - x^2*y^3

				var idx = ( j * w + i ) * 4;

				if ( f <= 0 ) {
					data[ idx ] = rgb.r;
					data[ idx + 1 ] = rgb.g;
					data[ idx + 2 ] = rgb.b;
					data[ idx + 3 ] = 255;
				} else {
					data[ idx + 3 ] = 0; // transparent outside the curve
				}
			}
		}

		ctx.putImageData( img, 0, 0 );
	}

	function initAll() {
		var canvases = document.querySelectorAll( '.heart-curve-canvas' );
		for ( var k = 0; k < canvases.length; k++ ) {
			drawHeart( canvases[ k ] );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initAll );
	} else {
		initAll();
	}
} )();
