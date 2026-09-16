<?php
/**
 * Plugin Name: Heart Curve Shortcode
 * Plugin URI:  https://gregwhitehead.com
 * Description: Renders the implicit heart curve (x^2+y^2-1)^3 - x^2*y^3 = 0, filled solid, via the [heart_curve] shortcode. Usage: [heart_curve width="400" height="400" color="#e60000" background="transparent" range="1.6"]
 * Version:     1.0.0
 * Author:      Greg Whitehead
 * License:     GPL-2.0+
 * Text Domain: heart-curve-shortcode
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Heart_Curve_Shortcode {

	const VERSION = '1.0.0';
	const HANDLE  = 'heart-curve-shortcode';

	public function __construct() {
		add_action( 'init', array( $this, 'register_assets' ) );
		add_shortcode( 'heart_curve', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Register (but don't force-enqueue) the JS. It only actually
	 * enqueues on pages that use the shortcode, via render_shortcode().
	 */
	public function register_assets() {
		wp_register_script(
			self::HANDLE,
			plugins_url( 'heart-curve.js', __FILE__ ),
			array(),
			self::VERSION,
			true // load in footer
		);
	}

	/**
	 * [heart_curve width="400" height="400" color="#e60000" background="transparent" range="1.6"]
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'width'      => '400',
				'height'     => '400',
				'color'      => '#e60000',
				'background' => 'transparent', // 'transparent' or any CSS color / hex
				'range'      => '1.6',          // math coordinate half-width shown (x and y from -range to +range)
			),
			$atts,
			'heart_curve'
		);

		// Sanitize.
		$width      = max( 20, absint( $atts['width'] ) );
		$height     = max( 20, absint( $atts['height'] ) );
		$color      = sanitize_text_field( $atts['color'] );
		$background = sanitize_text_field( $atts['background'] );
		$range      = (float) $atts['range'];
		if ( $range <= 0 ) {
			$range = 1.6;
		}

		// Make sure the drawing script is actually loaded on this page.
		wp_enqueue_script( self::HANDLE );

		static $instance = 0;
		$instance++;
		$id = 'heart-curve-canvas-' . $instance . '-' . wp_rand( 1000, 9999 );

		$css_bg = ( 'transparent' === $background ) ? 'transparent' : esc_attr( $background );

		ob_start();
		?>
		<canvas
			id="<?php echo esc_attr( $id ); ?>"
			class="heart-curve-canvas"
			width="<?php echo esc_attr( $width ); ?>"
			height="<?php echo esc_attr( $height ); ?>"
			data-color="<?php echo esc_attr( $color ); ?>"
			data-range="<?php echo esc_attr( $range ); ?>"
			style="background:<?php echo $css_bg; ?>; max-width:100%; display:block; margin:0 auto;"
		>
			Your browser does not support the canvas element.
		</canvas>
		<?php
		return ob_get_clean();
	}
}

new Heart_Curve_Shortcode();
