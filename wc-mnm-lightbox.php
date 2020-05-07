<?php
/**
 * Plugin Name: WooCommerce Mix and Match: Lightbox
 * Plugin URI: http://www.woocommerce.com/products/woocommerce-mix-and-match-products/
 * Version: 1.0.0-beta-2
 * Description: Add pop-up lightbox for child products. 
 * Author: Kathy Darling
 * Author URI: http://kathyisawesome.com/
 * Text Domain: wc-mnm-lightbox
 * Domain Path: /languages
 *
 * Copyright: © 2020 Kathy Darling
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */



/**
 * The Main WC_MNM_Lightbox class
 **/
if ( ! class_exists( 'WC_MNM_Lightbox' ) ) :

class WC_MNM_Lightbox {

	/**
	 * constants
	 */
	CONST VERSION = '1.0.0-beta-2';


	/**
	 * WC_MNM_Lightbox Constructor
	 *
	 * @access 	public
     * @return 	WC_MNM_Lightbox
	 */
	public static function init() {

		// Display Scripts.
		add_action( 'woocommerce_mix-and-match_add_to_cart', array( __CLASS__, 'load_scripts' ) );

		// QuickView support.
		add_action( 'wc_quick_view_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );

		// Replace the thumbnail template.
		add_filter( 'wc_get_template', array( __CLASS__, 'filter_template' ), 10, 5 );

    }


	/*-----------------------------------------------------------------------------------*/
	/* Scripts and Styles */
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Load the script anywhere the MNN add to cart button is displayed
	 * @return void
	 */
	public static function load_scripts() {

		if( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
			wp_enqueue_script( 'wc-mnm-lightbox', plugins_url( 'js/wc-mnm-lightbox.js', __FILE__ ), array( 'wc-add-to-cart-mnm' ), self::VERSION, true );
		}

	}

	/*-----------------------------------------------------------------------------------*/
	/* Display                                                                           */
	/*-----------------------------------------------------------------------------------*/

	/**
	 *
	 * Replace default filter with new one.
	 * 
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments. (default: array).
	 * @param string $template_path Template path. (default: '').
	 * @param string $default_path  Default path. (default: '').
	 * @return string
	 */
	public static function filter_template( $template, $template_name, $args, $template_path, $default_path ) {

		if( 'single-product/mnm/mnm-product-thumbnail.php' === $template_name ) {

			$new_path = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/';
			$new_template = wc_locate_template( $template_name, $template_path, $new_path );

			if ( $new_template ) {
				$template = $new_template;
			}

		}

		return $template;

	}


} //end class: do not remove or there will be no more guacamole for you

endif; // end class_exists check

// Launch the whole plugin.
add_action( 'plugins_loaded', array( 'WC_MNM_Lightbox', 'init' ) );
