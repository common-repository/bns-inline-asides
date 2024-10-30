<?php
/*
Plugin Name: BNS Inline Asides
Plugin URI: http://buynowshop.com/plugins/bns-inline-asides/
Description: This plugin will allow you to style sections of post content with added emphasis by leveraging a style element from the active theme.
Version: 1.3.2
Text Domain: bns-inline-asides
Author: Edward Caissie
Author URI: http://edwardcaissie.com/
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * BNS Inline Asides
 *
 * This plugin will allow you to style sections of post content with added
 * emphasis by leveraging a style element from the active theme.
 *
 * @package        BNS_Inline_Asides
 * @version        1.3.2
 *
 * @link           http://buynowshop.com/plugins/bns-inline-asides/
 * @link           https://github.com/Cais/bns-inline-asides/
 * @link           https://wordpress.org/plugins/bns-inline-asides/
 *
 * @author         Edward Caissie <edward.caissie@gmail.com>
 * @copyright      Copyright (c) 2011-2018, Edward Caissie
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @version        1.3.2
 * @date           July 2018
 */

/** Credits for jQuery assistance: Trevor Mills www.topquarkproductions.ca */

/** Let's begin ... */
class BNS_Inline_Asides {
	/**
	 * Constructor
	 *
	 * @package     BNS_Inline_Asides
	 * @since       0.1
	 *
	 * @internal    Requires WordPress version 3.6
	 * @internal    @uses shortcode_atts - uses optional filter variable
	 *
	 * @uses        (CONSTANT)  WP_CONTENT_DIR
	 * @uses        (GLOBAL)    $wp_version
	 * @uses        __
	 * @uses        add_action
	 * @uses        add_shortcode
	 * @uses        content_url
	 * @uses        plugin_dir_url
	 * @uses        plugin_dir_path
	 *
	 * @version     1.1
	 * @date        May 3, 2014
	 * Corrected textdomain typo
	 * Updated required version to 3.6 due to use of optional filter variable in `shortcode_atts`
	 * Define location for BNS plugin customizations
	 *
	 * @version     1.2
	 * @date        November 3, 2014
	 * Added sanity checks for `BNS_CUSTOM_*` define statements
	 * Corrections for textdomain to use plugin slug
	 *
	 * @version     1.3.1
	 * @date        July 4, 2018
	 * Correct text message to be displayed.
	 */
	function __construct() {

		/**
		 * WordPress version compatibility
		 * Check installed WordPress version for compatibility
		 */
		global $wp_version;
		$exit_message = __( 'BNS Inline Asides requires WordPress version 3.6 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please Update!</a>', 'bns-inline-asides' );
		if ( version_compare( $wp_version, "3.6", "<" ) ) {
			exit ( $exit_message );
		}

		/** Define some constants to save some keying */
		define( 'BNSIA_URL', plugin_dir_url( __FILE__ ) );
		define( 'BNSIA_PATH', plugin_dir_path( __FILE__ ) );

		/** Define location for BNS plugin customizations */
		if ( ! defined( 'BNS_CUSTOM_PATH' ) ) {
			define( 'BNS_CUSTOM_PATH', WP_CONTENT_DIR . '/bns-customs/' );
		}
		if ( ! defined( 'BNS_CUSTOM_URL' ) ) {
			define( 'BNS_CUSTOM_URL', content_url( '/bns-customs/' ) );
		}

		/** Added i18n support */
		load_plugin_textdomain( 'bns-inline-asides' );

		/** Enqueue Scripts and Styles */
		add_action(
			'wp_enqueue_scripts', array(
				$this,
				'scripts_and_styles'
			)
		);

		/**
		 * Add Shortcode
		 * @example  [aside]text[/aside]
		 * @internal default type="Aside"
		 * @internal default element='' (an empty string)
		 * @internal default status="open"
		 * @internal default show="To see the <em>%s</em> click here."
		 * @internal default hide="To hide the <em>%s</em> click here."
		 */
		add_shortcode( 'aside', array( $this, 'bns_inline_asides_shortcode' ) );

	}


	/**
	 * Enqueue Plugin Scripts and Styles
	 *
	 * Adds plugin stylesheet and allows for custom stylesheet to be added by end-user.
	 *
	 * @package BNS_Inline_Asides
	 * @since   0.4.1
	 *
	 * @uses    (CONSTANT)   BNS_CUSTOM_PATH
	 * @uses    (CONSTANT)   BNS_CUSTOM_URL
	 * @uses    (CONSTANT)   BNSIA_PATH
	 * @uses    (CONSTANT)   BNSIA_URL
	 * @uses    BNS_Inline_Asides::plugin_data
	 * @uses    wp_enqueue_script
	 * @uses    wp_enqueue_style
	 *
	 * @version 1.0
	 * @date    April 3, 2013
	 * Adjusted path to scripts and styles files
	 * Removed direct jQuery enqueue
	 *
	 * @version 1.0.3
	 * @date    December 28, 2013
	 * Added functional option to put `bnsia-custom-types.css` in `/wp-content/` folder
	 *
	 * @version 1.1
	 * @date    May 4, 2014
	 * Apply `plugin_data` method
	 * Moved JavaScript enqueue to footer
	 * Moved custom CSS folder location to `/wp-content/bns-customs/`
	 *
	 * @version 1.2
	 * @date    November 3, 2014
	 * Renamed from `BNSIA_Scripts_and_Styles` to `scripts_and_styles`
	 */
	function scripts_and_styles() {

		/** @var object $bnsia_data - holds the plugin header data */
		$bnsia_data = $this->plugin_data();

		/** Enqueue Scripts */
		/** Enqueue toggling script which calls jQuery as a dependency */
		wp_enqueue_script( 'bnsia_script', BNSIA_URL . 'js/bnsia-script.js', array( 'jquery' ), $bnsia_data['Version'], true );

		/** Enqueue Style Sheets */
		wp_enqueue_style( 'BNSIA-Style', BNSIA_URL . 'css/bnsia-style.css', array(), $bnsia_data['Version'], 'screen' );

		/** This location is not recommended as it is not upgrade safe. */
		if ( is_readable( BNSIA_PATH . 'bnsia-custom-types.css' ) ) {
			wp_enqueue_style( 'BNSIA-Custom-Types', BNSIA_URL . 'bnsia-custom-types.css', array(), $bnsia_data['Version'], 'screen' );
		}

		/** This location is recommended as upgrade safe */
		if ( is_readable( BNS_CUSTOM_PATH . 'bnsia-custom-types.css' ) ) {
			wp_enqueue_style( 'BNSIA-Custom-Types', BNS_CUSTOM_URL . 'bnsia-custom-types.css', array(), $bnsia_data['Version'], 'screen' );
		}

	}


	/**
	 * BNS Inline Asides Shortcode
	 *
	 * @package    BNS_Inline_Asides
	 * @since      0.1
	 *
	 * @param        $atts    - shortcode attributes
	 * @param   null $content - the content
	 *
	 * @uses       BNS_Inline_Asides::bnsia_theme_element
	 * @uses       _x
	 * @uses       do_shortcode
	 * @uses       sanitize_html_class
	 * @uses       shortcode_atts
	 * @uses       wp_localize_script
	 *
	 * @return  string
	 *
	 * @version    0.9
	 * @date       January 4, 2013
	 * Moved JavaScript into its own file and pass the element variable via
	 * wp_localize_script
	 *
	 * @version    1.0
	 * @date       Rat Day, 2013
	 * Added missing `bnsia` class to theme elements other than default
	 * Refactored $bnsia_element to simply $element
	 * Removed global variable $bnsia_element as not used
	 *
	 * @version    1.0.2
	 * @date       August 3, 2013
	 * Added dynamic filter parameter
	 *
	 * @version    1.0.3
	 * @date       December 30, 2013
	 * Code reductions (see `replace_spaces` usage)
	 *
	 * @version    1.2
	 * @date       November 3, 2014
	 * Added `_x` i18n implementation to `show` and `hide` default messages
	 * Replaced `BNS_Inline_Asides::replace_spaces` with `sanitize_html_class` functionality
	 */
	function bns_inline_asides_shortcode( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'type'    => 'Aside',
					'element' => '',
					'show'    => _x( 'To see the <em>%s</em> click here.', '%s is a PHP replacement variable', 'bns-inline-asides' ),
					'hide'    => _x( 'To hide the <em>%s</em> click here.', '%s is a PHP replacement variable', 'bns-inline-asides' ),
					'status'  => 'open',
				),
				$atts, 'aside'
			)
		);

		/** clean up shortcode properties */
		/** @var string $status - used as toggle switch */
		$status = esc_attr( strtolower( $status ) );
		if ( $status != "open" ) {
			$status = "closed";
		}

		/**
		 * @var string $type_class - leaves any end-user capitalization for aesthetics
		 * @var string $type       - Aside|end-user defined
		 */
		$type_class = sanitize_html_class( strtolower( $type ), 'aside' );

		/** no need to duplicate the default 'aside' class */
		if ( $type_class == 'aside' ) {
			$type_class = '';
		} else {
			$type_class = ' ' . $type_class;
		}

		/** @var $element - default is null|empty */
		$element = sanitize_html_class( strtolower( $element ), '' );

		// The secret sauce ...
		/** @var string $show - used as boolean control */
		/** @var string $hide - used as boolean control */
		$toggle_markup = '<div class="aside-toggler ' . $status . '">'
		                 . '<span class="open-aside' . $type_class . '">' . sprintf( __( $show ), esc_attr( $type ) ) . '</span>'
		                 . '<span class="close-aside' . $type_class . '">' . sprintf( __( $hide ), esc_attr( $type ) ) . '</span>
                         </div>';
		if ( $this->bnsia_theme_element( $element ) == '' ) {
			$return = $toggle_markup . '<div class="bnsia aside' . $type_class . ' ' . $status . '">' . do_shortcode( $content ) . '</div>';
		} else {
			$return = $toggle_markup . '<' . $this->bnsia_theme_element( $element ) . ' class="bnsia aside' . $type_class . ' ' . $status . '">' . do_shortcode( $content ) . '</' . $this->bnsia_theme_element( $element ) . '>';
		}

		/** Grab the element of choice and push it through the JavaScript */
		wp_localize_script( 'bnsia_script', 'element', $this->bnsia_theme_element( $element ) );

		return $return;

	}


	/**
	 * Replace Spaces
	 *
	 * Takes a string and replaces the spaces with a single hyphen by default
	 *
	 * @package     BNS_Inline_asides
	 * @since       0.8
	 *
	 * @internal    Original code from Opus Primus by Edward "Cais" Caissie ( mailto:edward.caissie@gmail.com )
	 *
	 * @param   string $text
	 * @param   string $replacement
	 *
	 * @return  string - class
	 *
	 * @deprecated  1.2
	 * @date        November 3, 2014
	 * Replaced with `sanitize_html_class` functionality
	 */
	function replace_spaces( $text, $replacement = '-' ) {

		/** @var $new_text - initial text set to lower case */
		$new_text = esc_attr( strtolower( $text ) );
		/** replace whitespace with a single space */
		$new_text = preg_replace( '/\s\s+/', ' ', $new_text );
		/** replace space with a hyphen to create nice CSS classes */
		$new_text = preg_replace( '/\\040/', $replacement, $new_text );

		/** Return the string with spaces replaced by the replacement variable */

		return $new_text;

	}


	/**
	 * BNSIA Theme Element
	 *
	 * Plugin currently supports the following HTML tags: aside, blockquote,
	 * code, h1 through h6, pre, and q; or uses the default <div class = bnsia>
	 *
	 * @package  BNS_Inline_Asides
	 * @since    0.6
	 *
	 * @param    string $element taken from shortcode $atts( 'element' ).
	 *
	 * @return string accepted HTML tag | empty
	 *
	 * @internal The HTML `p` tag is not recommended at this time (version 0.8),
	 * especially for text that spans multiple paragraphs
	 *
	 * @version  0.6.1
	 * @date     November 22, 2011
	 * Corrected issue with conditional - Fatal error: Cannot re-declare bnsia_theme_element()
	 *
	 * @version  0.8
	 * @date     November 15, 2012
	 * Accept the shortcode $att( 'element' ) and return the value for use with
	 * the output strings if it is an accepted HTML tag
	 *
	 * @version  1.0
	 * @date     Rat Day, 2013
	 * Use an array of elements rather than a convoluted if statement
	 *
	 * @version  1.3.1
	 * @date     July 4, 2018
	 * Adjust $element to be used and returned as an array
	 *
	 * @version 1.3.2
	 * @date    July 24, 2018
	 * Set return value as string (and remove forcing $element to array).
	 */
	protected function bnsia_theme_element( $element ) {

		// @var array $accepted_elements block level container elements.
		$accepted_elements = array(
			'aside',
			'blockquote',
			'code',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'pre',
			'q',
		);

		/**
		 * Check if an element has been used: if not, get out; otherwise,
		 * check if the element is accepted or return nothing if it is not.
		 */
		if ( empty( $element ) ) {
			return null;
		} elseif ( in_array( $element, $accepted_elements, true ) ) {
			return $element;
		} else {
			return null;
		}

	}


	/**
	 * Plugin Data
	 *
	 * Returns the plugin header data as an array
	 *
	 * @package    BNS_Inline_Asides
	 * @since      1.1
	 *
	 * @uses       get_plugin_data
	 *
	 * @return array
	 */
	function plugin_data() {

		/** Call the wp-admin plugin code */
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		/** @var $plugin_data - holds the plugin header data */
		$plugin_data = get_plugin_data( __FILE__ );

		return $plugin_data;

	}


}


/** @var $bns_inline_asides - instantiate the class */
$bns_inline_asides = new BNS_Inline_Asides();


/**
 * BNS Inline Asides Update Message
 *
 * @package BNS_Inline_Asides
 * @since   1.3
 *
 * @uses    get_transient
 * @uses    is_wp_error
 * @uses    set_transient
 * @uses    wp_kses_post
 * @uses    wp_remote_get
 *
 * @param $args
 */
function bnsia_in_plugin_update_message( $args ) {

	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	$bnsia_data = get_plugin_data( __FILE__ );

	$transient_name = 'bnsia_upgrade_notice_' . $args['Version'];
	if ( false === ( $upgrade_notice = get_transient( $transient_name ) ) ) {

		/** @var string $response - get the readme.txt file from WordPress */
		$response = wp_remote_get( 'https://plugins.svn.wordpress.org/bns-inline-asides/trunk/readme.txt' );

		if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
			$matches = null;
		}
		$regexp         = '~==\s*Changelog\s*==\s*=\s*(.*)\s*=(.*)(=\s*' . preg_quote( $bnsia_data['Version'] ) . '\s*=|$)~Uis';
		$upgrade_notice = '';

		if ( preg_match( $regexp, $response['body'], $matches ) ) {
			$version = trim( $matches[1] );
			$notices = (array) preg_split( '~[\r\n]+~', trim( $matches[2] ) );

			if ( version_compare( $bnsia_data['Version'], $version, '<' ) ) {

				/** @var string $upgrade_notice - start building message (inline styles) */
				$upgrade_notice = '<style type="text/css">
							.bnsia_plugin_upgrade_notice { padding-top: 20px; }
							.bnsia_plugin_upgrade_notice ul { width: 50%; list-style: disc; margin-left: 20px; margin-top: 0; }
							.bnsia_plugin_upgrade_notice li { margin: 0; }
						</style>';

				/** @var string $upgrade_notice - start building message (begin block) */
				$upgrade_notice .= '<div class="bnsia_plugin_upgrade_notice">';

				$ul = false;

				foreach ( $notices as $index => $line ) {

					if ( preg_match( '~^=\s*(.*)\s*=$~i', $line ) ) {

						if ( $ul ) {
							$upgrade_notice .= '</ul><div style="clear: left;"></div>';
						}
						/** End if - unordered list created */

						$upgrade_notice .= '<hr/>';
						continue;

					}
					/** End if - non-blank line */

					/** @var string $return_value - body of message */
					$return_value = '';

					if ( preg_match( '~^\s*\*\s*~', $line ) ) {

						if ( ! $ul ) {
							$return_value = '<ul">';
							$ul           = true;
						}
						/** End if - unordered list not started */

						$line         = preg_replace( '~^\s*\*\s*~', '', htmlspecialchars( $line ) );
						$return_value .= '<li style=" ' . ( $index % 2 == 0 ? 'clear: left;' : '' ) . '">' . $line . '</li>';

					} else {

						if ( $ul ) {
							$return_value = '</ul><div style="clear: left;"></div>';
							$return_value .= '<p>' . $line . '</p>';
							$ul           = false;
						} else {
							$return_value .= '<p>' . $line . '</p>';
						}
						/** End if - unordered list started */

					}
					/** End if - non-blank line */

					$upgrade_notice .= wp_kses_post( preg_replace( '~\[([^\]]*)\]\(([^\)]*)\)~', '<a href="${2}">${1}</a>', $return_value ) );

				}
				/** End foreach - line parsing */

				$upgrade_notice .= '</div>';

			}
			/** End if - version compare */

		}
		/** End if - response message exists */

		/** Set transient - minimize calls to WordPress */
		set_transient( $transient_name, $upgrade_notice, DAY_IN_SECONDS );

	}
	/** End if - transient check */

	echo $upgrade_notice;

}

/** End function - in plugin update message */
add_action( 'in_plugin_update_message-' . plugin_basename( __FILE__ ), 'bnsia_in_plugin_update_message' );
